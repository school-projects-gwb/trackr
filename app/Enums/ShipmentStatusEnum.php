<?php

namespace App\Enums;

enum ShipmentStatusEnum:string{
    case Registered = 'registered';
    case Printed = 'printed';
    case Delivered = 'delivered';
    case Sorting = 'sorting';
    case Transit = 'transit';
}
