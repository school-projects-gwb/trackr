<?php

namespace App\Helpers;

class TrackingNumberGenerator
{
    public static function generate($shipmentId, $carrierName): string
    {
        return strtoupper('TRACKR' . $shipmentId . substr($carrierName, 0, 2));
    }
}
