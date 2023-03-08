<?php

namespace App\Http\Middleware;

use App\Models\Shipment;
use App\Models\Webstore;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\WebstoreToken;
use Illuminate\Support\Facades\Auth;

class StoreLabelingAllowed
{
    /**
     * Check whether shipment_id's in request are all part of the store user
     * @param Request $request
     * @param Closure $next
     * @return false|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Make sure shipment_id is present and has at least 1 store ID in it
        if (!isset($request->shipment_id) && count($request->shipment_id) > 0) {
            return abort(403);
        }

        foreach ($request->shipment_id as $id) {
            // Make sure shipment exists
            $shipment = Shipment::find($id);
            $selectedStoreId = $request->cookie('selected_store_id');
            if (!$shipment || $shipment->webstore_id != $selectedStoreId || $shipment->carrier_id != '' || $shipment->tracking_number != '') {
                return abort(403);
            }
        }

        return $next($request);
    }
}
