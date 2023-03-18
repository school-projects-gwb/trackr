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
            self::Registered => __('Ingevoerd in ons systeem.'),
            self::Printed => __('Aangemeld bij de bezorger.'),
            self::Sorting => __('Verwerkt in het sorteercentrum van de bezorger.'),
            self::Transit => __('Onderweg met de bezorger.'),
            self::Delivered => __('Bezorgd.'),
            default => $this->value,
        };
    }

    public function getShortLabel(): string {
        return match ($this) {
            self::Registered => __('Geregistreerd'),
            self::Printed => __('Aangemeld'),
            self::Sorting => __('Gesorteerd'),
            self::Transit => __('Onderweg'),
            self::Delivered => __('Bezorgd'),
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
