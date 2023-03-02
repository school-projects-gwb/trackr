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
            $shipments = $shipments->get();
        } else {
            $shipments = $shipments->paginate(15);

            foreach ($shipments as $shipment) {
                if ($shipment->ShipmentStatuses->count() > 1) {
                    $shipment->setRelation('ShipmentStatuses', collect([$shipment->ShipmentStatuses->first()]));
                }
            }
        }


        if (request('status') != '') {
            $filteredShipments = $shipments->filter(function ($shipment) {
                $latestStatus = $shipment->ShipmentStatuses->first();

                if ($latestStatus && $latestStatus->status->value == request('status')) {
                    $shipment->setRelation('ShipmentStatuses', collect([$latestStatus]));
                    return true;
                }

                return false;
            });

            $perPage = 15;
            $page = request('page', 1);
            $offset = ($page - 1) * $perPage;

            $shipments = new LengthAwarePaginator(
                $filteredShipments->slice($offset, $perPage),
                $filteredShipments->count(),
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );
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
        for($i = 0; $i < count($statuses); $i++) {
            if ($statuses[$i]->value == request('status')) {
                unset($statuses[$i]);
            }
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
