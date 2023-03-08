<?php

namespace App\Imports;

use App\Services\ShipmentCreationService;
use http\Env\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;

class ShipmentsImport implements ToCollection
{

    private Collection $shipmentsData;
    use Importable;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $this->shipmentsData = $collection->map(fn($shipment) => [
            'weight' => $shipment[0],
            'streetname' => $shipment[1],
            'housenumber' => $shipment[2],
            'postalcode' => $shipment[3],
            'city' => $shipment[4],
            'country' => $shipment[5],
            'carrier' => $shipment[6],
        ]);
    }

    public function getData() :Collection{
        return $this->shipmentsData;
    }
}
