<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class DateIsTwoDaysInPast implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $futureTimeDate = Carbon::now()->addHours(48);
        $dateToCheck = Carbon::parse($value);
        return $dateToCheck->gte($futureTimeDate);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'De ophaal datum moet minimaal 2 dagen van de voren voor 15:00 ingepland zijn';
    }
}
