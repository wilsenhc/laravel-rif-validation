<?php

namespace Wilsenhc\ValidarRif\Rules;

use Illuminate\Contracts\Validation\Rule;

class Rif implements Rule
{
    /** @var string */
    protected $attribute;

    /**
     * Determinar si el RIF en cuestion es valido.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $this->attribute = $attribute;

        // Verificar si el RIF tiene el formato valido
        if (!preg_match('/^[VEPJGC]-?[\d]{8}-?[\d]$/i', $value))
        {
            return false;
        }

        $rif = strtoupper($value);
        $rif = str_replace('-', '', $value);

        // TODO: Añadir lógica para calcular el digito verificador.
        return true;
    }

    /**
     * Obtener el mensaje de error de la validación.
     *
     * @return string
     */
    public function message(): string
    {
        return 'El RIF no es válido';
    }
}