<?php

namespace App\Enums;

enum ShipmentStatusEnum: string{
    case Registered = 'registered';
    case Printed = 'printed';
    case Sorting = 'sorting';
    case Transit = 'transit';
    case Delivered = 'delivered';

    public function getDescription(): string {
        return match ($this) {
            self::Registered => 'Ingevoerd in ons systeem.',
            self::Printed => 'Aangemeld bij de bezorger.',
            self::Sorting => 'Verwerkt in het sorteercentrum van de bezorger.',
            self::Transit => 'Onderweg met de bezorger.',
            self::Delivered => 'Bezorgd.',
            default => $this->value,
        };
    }

    public function getShortLabel(): string {
        return match ($this) {
            self::Registered => 'Geregistreerd',
            self::Printed => 'Aangemeld',
            self::Sorting => 'Gesorteerd',
            self::Transit => 'Onderweg',
            self::Delivered => 'Bezorgd',
            default => $this->value,
        };
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
