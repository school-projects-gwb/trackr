<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class TimeIsBeforeThree implements Rule
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
        $mustBefore = Carbon::parse('15:00:00');
        $timeToCheck = Carbon::parse($value);
//        dd($timeToCheck);
        return $mustBefore->gt($timeToCheck->format('H:i:s'));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'De ophaaltijd moet voor 15:00 zijn.';
    }
}
