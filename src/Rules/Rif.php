<?php

namespace Wilsenhc\RifValidation\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;
use Wilsenhc\RifValidation\RifValidator;

class Rif implements ValidationRule
{
    /** @var string */
    protected $attribute;

    /** @var \Wilsenhc\RifValidation\RifValidator */
    protected RifValidator $validator;

    public function __construct()
    {
        $this->validator = new RifValidator();
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->attribute = $attribute;

        if ($this->validator->isValid($value)) {
            return;
        }

        $fail(Str::replace(':attribute', $this->attribute, __('validateRif::messages.rif')));
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

        return $this->validator->isValid($value);
    }
}
