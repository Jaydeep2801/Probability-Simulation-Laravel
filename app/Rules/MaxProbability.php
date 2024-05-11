<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Prize;

class MaxProbability implements Rule
{
    /**
     * The ID to exclude from the sum when calculating current probability.
     *
     * @var int
     */
    protected $excludeId;

    /**
     * Create a new rule instance.
     *
     * @param  mixed  $excludeId
     * @return void
     */
    public function __construct($excludeId = null)
    {
        $this->excludeId = $excludeId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * 
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->excludeId) {
            $currentSum = Prize::where('id', '!=', $this->excludeId)->sum('probability');
        } else {
            $currentSum = Prize::sum('probability');
        }

        $maxProbability = round( 100 - $currentSum, 2);

        return $currentSum + $value <= 100 && $value <= $maxProbability;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if( $this->excludeId ){
            $currentSum = Prize::where('id', '!=', $this->excludeId)->sum('probability');
        } else {
            $currentSum = Prize::sum('probability');
        }

        $maxProbability = round( 100 - $currentSum, 2);

        return "The probability field must not greater than $maxProbability.";
    }
}
