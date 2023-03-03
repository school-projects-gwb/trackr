<?php


namespace App\Filters;


use Illuminate\Pagination\LengthAwarePaginator;

class ShipmentStatus
{
    public static function apply($statusFilter, $shipmentCollection, $itemsPerPage) {
        if (request('status') != '') {
            // Add status filter and filter out all statuses that aren't the latest
            $shipments = $shipmentCollection->get();

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

            return $shipments;
        } else {
            // Get paginated collection and filter out all statuses that aren't the latest
            $shipments = $shipmentCollection->paginate($itemsPerPage);

            foreach ($shipments as $shipment) {
                if ($shipment->ShipmentStatuses->count() > 1) {
                    $shipment->setRelation('ShipmentStatuses', collect([$shipment->ShipmentStatuses->first()]));
                }
            }

            return $shipments;
        }
    }

    public static function values() {
        $statuses = \App\Enums\ShipmentStatusEnum::cases();

        for ($i = 0; $i < count($statuses); $i++) {
            $statuses[$i] = $statuses[$i]->value;
        }

        return $statuses;
    }
}
