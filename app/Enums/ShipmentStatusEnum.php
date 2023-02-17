<?php

namespace App\Enums;

enum ShipmentStatusEnum: string{
    case Registered = 'registered';
    case Printed = 'printed';
    case Sorting = 'sorting';
    case Transit = 'transit';
    case Delivered = 'delivered';

    public function getDescription(): string {
        switch ($this) {
            case self::Registered:
                return 'Je pakket is ingevoerd in ons systeem.';
            case self::Printed:
                return 'Je pakket is aangemeld';
            case self::Sorting:
                return 'Je pakket is in het sorteercentrum.';
            case self::Transit:
                return 'Je pakket is onderweg met de bezorger.';
            case self::Delivered:
                return 'Je pakket is bezorgd.';
            default:
                return $this->value;
        }
    }

    public static function fromValue(string $searchValue): ?self
    {
        $values = self::cases();

        foreach ($values as $val) {
            if ($val->value == $searchValue) {
                return $val;
            }
        }

        return null;
    }
}
