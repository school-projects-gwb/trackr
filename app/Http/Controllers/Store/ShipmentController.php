<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressUpdateRequest;
use App\Http\Requests\StoreCreateRequest;
use App\Http\Requests\StoreUpdateRequest;
use App\Models\Address;
use App\Models\Shipment;
use App\Models\ShipmentStatus;
use App\Models\Webstore;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShipmentController extends Controller
{
    private string $defaultSortField = 'created_at';
    private array $sortableFields = ['id', 'tracking_number', 'created_at', 'carrier'];

    public function overview()
    {
        $user = Auth::user();

        $sortField = request('sort', $this->defaultSortField);
        $sortDirection = request('dir', 'asc');
        $sortableFields = $this->sortableFields;
        $itemsPerPage = 15;

        $filterValues = $this->getFilterValues();

        $shipments = Shipment::select('shipments.*')
            ->whereHas('store', function ($query) use ($user) {
                $query->whereHas('users', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                });
            })
            ->leftJoin('carriers', 'shipments.carrier_id', '=', 'carriers.id')
            ->with(['ShipmentStatuses' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->orderBy($this->getQueryTableFieldName($sortField), $sortDirection);

        if (request('status') != '') {
            // Add status filter and filter out all statuses that aren't the latest
            $shipments = $shipments->get();

            $filteredShipments = $shipments->filter(function ($shipment) {
                $latestStatus = $shipment->ShipmentStatuses->first();

                if ($latestStatus && $latestStatus->status->value == request('status')) {
                    $shipment->setRelation('ShipmentStatuses', collect([$latestStatus]));
                    return true;
                }

                return false;
            });

            $page = request('page', 1);
            $offset = ($page - 1) * $itemsPerPage;

            $shipments = new LengthAwarePaginator(
                $filteredShipments->slice($offset, $itemsPerPage),
                $filteredShipments->count(),
                $itemsPerPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        } else {
            // Get paginated collection and filter out all statuses that aren't the latest
            $shipments = $shipments->paginate($itemsPerPage);

            foreach ($shipments as $shipment) {
                if ($shipment->ShipmentStatuses->count() > 1) {
                    $shipment->setRelation('ShipmentStatuses', collect([$shipment->ShipmentStatuses->first()]));
                }
            }
        }

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

    private function getFilterValues() {
        $filterValues = [];
        $statuses = \App\Enums\ShipmentStatusEnum::cases();

        for ($i = 0; $i < count($statuses); $i++) {
            $statuses[$i] = $statuses[$i]->value;
        }

        $filterValues['status'] = $statuses;
        return $filterValues;
    }

    public function create()
    {
        return view('store.shipments.create');
    }

    public function edit(Shipment $store)
    {

    }

    public function update(Request $request, Shipment $store)
    {

    }

    public function store(Request $request)
    {

    }
}
