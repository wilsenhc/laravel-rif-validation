# A Validation rule to check if a RIF is valid

[![Latest Version on Packagist](https://img.shields.io/packagist/v/wilsenhc/laravel-rif-validation.svg?style=flat-square)](https://packagist.org/packages/wilsenhc/laravel-rif-validation)
![Tests](https://github.com/wilsenhc/laravel-rif-validation/actions/workflows/run-tests.yml/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/wilsenhc/laravel-rif-validation.svg?style=flat-square)](https://packagist.org/packages/wilsenhc/laravel-rif-validation)

This package provides rules to validate a RIF (Registro Único de Información Fiscal).

## Installation

You can install the package via composer:

```bash
composer require wilsenhc/laravel-rif-validation
```

The package will automatically register itself.

### Translations

If you wish to edit the package translations, you can run the following command to publish them into your `resources/lang` folder

```bash
php artisan vendor:publish --provider="Wilsenhc\RifValidation\RifValidationServiceProvider"
```

## Available rules

- [`Rif`](#rif)

### `Rif`

This validation rule will pass if the RIF value passed in the request is valid.

```php
// in a `FormRequest`

use Wilsenhc\RifValidation\Rules\Rif;

public function rules()
{
    return [
        'rif' => ['required', new Rif()],
    ];
}
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email wilsenforwork@gmail.com instead of using the issue tracker.

## Credits

- [Wilsen Hernández](https://github.com/wilsenhc)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.