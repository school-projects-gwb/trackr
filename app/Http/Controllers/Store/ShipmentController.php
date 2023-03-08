<?php

namespace App\Http\Controllers\Store;

use App\Filters\FullTextFilter;
use App\Filters\ShipmentStatusFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressUpdateRequest;
use App\Http\Requests\ImportShipmentRequest;
use App\Http\Requests\StoreCreateRequest;
use App\Http\Requests\StoreUpdateRequest;
use App\Imports\ShipmentsImport;
use App\Models\Address;
use App\Models\Shipment;
use App\Models\ShipmentStatus;
use App\Models\User;
use App\Models\Webstore;
use App\Services\ShipmentCreationService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Excel;

class ShipmentController extends Controller
{
    private string $defaultSortField = 'created_at';
    private array $sortableFields = ['id', 'tracking_number', 'created_at', 'carrier'];

    public function overview(Request $request)
    {
        $selectedStoreId = $request->cookie('selected_store_id');

        $sortField = request('sort', $this->defaultSortField);
        $sortDirection = request('dir', 'asc');
        $sortableFields = $this->sortableFields;
        $itemsPerPage = 15;

        $shipments = Shipment::select('shipments.*')
            ->where('webstore_id', $selectedStoreId)
            ->leftJoin('carriers', 'shipments.carrier_id', '=', 'carriers.id')
            ->with(['ShipmentStatuses' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }]);

        $shipments = FullTextFilter::apply($shipments, 'tracking_number', request('zoektermen'));
        $shipments->orderBy($this->getQueryTableFieldName($sortField), $sortDirection);
        $shipments = ShipmentStatusFilter::apply(request('status'), $shipments, $itemsPerPage);

        $filterValues = [];
        $filterValues['status'] = \App\Filters\ShipmentStatusFilter::values();
        $filterValues['zoektermen'] = request('zoektermen');

        return view(
            'store.shipments.overview',
            compact('shipments', 'sortField', 'sortDirection', 'sortableFields', 'filterValues'));
    }

    /**
     * @param $fieldName fieldName to get correctly formatted name of
     * @return string correctly formatted field name
     */
    public function getQueryTableFieldName($fieldName) {
        $formattedFieldName = $fieldName;

        if (!in_array($fieldName, $this->sortableFields)) {
            $formattedFieldName = $this->defaultSortField;
            return $formattedFieldName;
        }

        switch ($fieldName) {
            case "carrier":
                $formattedFieldName = "carriers.name";
                break;
            case "created_at":
                $formattedFieldName = "shipments.created_at";
                break;
        }

        return $formattedFieldName;
    }

    public function delete(Request $request, Shipment $shipment) {
        $shipment->delete();
        return to_route('store.shipments.overview');
    }

    public function importShipment(ImportShipmentRequest $request){
        $shipmentsImport = new ShipmentsImport();
        Excel::import($shipmentsImport, $request->csvFile);
        ShipmentCreationService::createShipments($shipmentsImport->getData()->toArray(), $request->cookie('selected_store_id'));
        return back();
    }
}
