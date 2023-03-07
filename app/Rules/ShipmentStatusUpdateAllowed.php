<?php

namespace App\Rules;

use App\Filters\ShipmentStatusFilter;
use App\Models\ShipmentStatus;
use Illuminate\Contracts\Validation\Rule;

class ShipmentStatusUpdateAllowed implements Rule
{
    protected $_shipmentId;
    protected $_shipmentStatusses;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $shipmentId)
    {
        $this->_shipmentId = $shipmentId;
        $this->_shipmentStatusses = ShipmentStatusFilter::values();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $valueIndex = array_search($value, $this->_shipmentStatusses);
        return ShipmentStatus::where('shipment_id', $this->_shipmentId)->where('status', $this->_shipmentStatusses[max(0, $valueIndex - 1)])->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Shipment ' . $this->_shipmentId . ' kon niet naar de nieuwe status worden gezet.';
    }
}
