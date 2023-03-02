<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressUpdateRequest;
use App\Http\Requests\StoreCreateRequest;
use App\Http\Requests\StoreUpdateRequest;
use App\Models\Address;
use App\Models\Shipment;
use App\Models\Webstore;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends Controller
{
    public function overview()
    {
        $user = Auth::user();

        $sortField = request('sort', 'name');
        $sortDirection = request('dir', 'asc');

        $shipments = Shipment::whereHas('store', function ($query) use ($user) {
            $query->whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        })
            ->leftJoin('carriers', 'shipments.carrier_id', '=', 'carriers.id')
            ->orderBy($this->getQueryTableFieldName($sortField), $sortDirection)->paginate(5);

        return view('store.shipments.overview', compact('shipments', 'sortField', 'sortDirection'));
    }

    /**
     * @param $fieldName field to get correctly formatted name of
     * @return string correctly formatted field name
     */
    public function getQueryTableFieldName($fieldName) {
        $val = $fieldName;

        switch ($fieldName) {
            case "carrier":
                $val = "carriers.name";
                break;
            default:
                $val = $fieldName;
        }

        return $val;
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
