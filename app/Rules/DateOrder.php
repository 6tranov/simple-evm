<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DateOrder implements Rule
{
    private $startDate = NULL;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        //
        if(is_null($this->startDate)){
            $this->startDate = new \DateTime($value);
            return true;
        } 
        
        return ($this->startDate <= new \DateTime($value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '日付の順番がおかしいです。';
    }
}
