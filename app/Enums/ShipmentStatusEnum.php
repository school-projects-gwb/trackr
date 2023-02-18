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
                return 'Ingevoerd in ons systeem.';
            case self::Printed:
                return 'Aangemeld bij de bezorger.';
            case self::Sorting:
                return 'Verwerkt in het sorteercentrum van de bezorger.';
            case self::Transit:
                return 'Onderweg met de bezorger.';
            case self::Delivered:
                return 'Bezorgd.';
            default:
                return $this->value;
        }
    }

    public function getShortLabel(): string {
        switch ($this) {
            case self::Registered:
                return 'Geregistreerd';
            case self::Printed:
                return 'Aangemeld';
            case self::Sorting:
                return 'Gesorteerd';
            case self::Transit:
                return 'Onderweg';
            case self::Delivered:
                return 'Bezorgd';
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
