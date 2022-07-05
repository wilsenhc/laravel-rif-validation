<?php

namespace Wilsenhc\RifValidation\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class Rif implements Rule
{
    /** @var string */
    protected $attribute;

    /** @var array */
    protected $nationality_array;

    /** @var array */
    protected $multipliers;

    public function __construct()
    {
        $this->nationality_array = [
            'V' => '1',
            'E' => '2',
            'J' => '3',
            'P' => '4',
            'G' => '5',
            'C' => '3',
        ];

        $this->multipliers = [4, 3, 2, 7 ,6, 5, 4, 3, 2];
    }

    /**
     * Determine if the RIF validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $this->attribute = $attribute;

        $value = Str::upper($value);

        // Verificar si el RIF tiene el formato valido
        if (!preg_match('/^[VEPJGC]-?[\d]{8}-?[\d]$/i', $value))
        {
            return false;
        }

        $full_rif = strtoupper($value);
        $full_rif = str_replace('-', '', $value);

        $contributor = substr($full_rif, 0, -1);
        $validationNumber = substr($full_rif, -1, 1);

        return $this->validationNumber($contributor) == $validationNumber;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('validateRif::messages.rif', [
            'attribute' => $this->attribute,
        ]);
    }

    /**
     * Calcate the Validation Number
     *
     * @param  string  $rif
     * @return string
     */
    private function validationNumber($rif): string
    {
        // FIRST STEP:
        // Replace the letter for its numeric value.
        $rif[0] = $this->nationality_array[$rif[0]];

        $split_rif = str_split($rif);

        // SECOND STEP
        // Multiply each value by its *constant* multiplier from the multipiers
        // array.
        $sum = 0;
        foreach ($split_rif as $index => $value)
        {
            $sum += intval($value) * $this->multipliers[$index];
        }

        // THIRD STEP
        $remainder = intval($sum % 11);

        // FOURTH STEP
        $difference = 11 - $remainder;

        // FINAL STEP
        return ($difference > 9) ? '0' : strval($difference);
    }
}