<?php

namespace Wilsenhc\RifValidation\Tests\Rules;

use Orchestra\Testbench\TestCase;

use Wilsenhc\RifValidation\Rules\Rif;
use Wilsenhc\RifValidation\RifValidationServiceProvider;

class RifTest extends TestCase
{
    /**
     * @var  \Wilsenhc\RifValidation\Rules\Rif  $rule
     */
    protected $rule;

    /**
     * @var  \Illuminate\Validation\Factory  $validator
     */
    protected $validator;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->rule = new Rif();

        $this->validator = $this->app['validator'];
    }

    protected function getPackageProviders($app)
    {
        return [
            RifValidationServiceProvider::class,
        ];
    }

    public function testItWillReturnVoidIfRifIsValid()
    {
        // Valid RIF of "Universidad de Carabobo"
        $rif = 'G-20000041-4';

        $this->assertNull($this->rule->validate('rif', $rif, fn () => null));

        // Valid RIF of "Banesco Banco Universal"
        $rif = 'J-07013380-5';

        $this->assertNull($this->rule->validate('rif', $rif, fn () => null));

        // Valid RIF of "Nicolas Maduro Moros"
        $rif = 'V-05892464-0';

        $this->assertNull($this->rule->validate('rif', $rif, fn () => null));
    }

    public function testItWillReturnFalseIfFormatIsInvalid()
    {
        // Starts with a RIF Type that doesn't exist
        $rif = 'Q-00000000-0';

        $this->assertNull($this->rule->validate('rif', $rif, fn ($value) => $this->assertNotNull($value)));

        // Extra number
        $rif = 'G-200000041-4';

        $this->assertNull($this->rule->validate('rif', $rif, fn ($value) => $this->assertNotNull($value)));

        // Missing numbers
        $rif = 'V-5892464';

        $this->assertNull($this->rule->validate('rif', $rif, fn ($value) => $this->assertNotNull($value)));

        // Letter where there should be only numbers
        $rif = 'G-200F00041-F';

        $this->assertNull($this->rule->validate('rif', $rif, fn ($value) => $this->assertNotNull($value)));
    }

    public function testItWillConvertValuesToUppercaseBeforeTesting()
    {
        // Valid RIF of "Universidad de Carabobo"
        $rif = 'g-20000041-4';

        $this->assertNull($this->rule->validate('rif', $rif, fn () => null));

        // Valid RIF of "Banesco Banco Universal"
        $rif = 'j-07013380-5';

        $this->assertNull($this->rule->validate('rif', $rif, fn () => null));

        // Valid RIF of "Nicolas Maduro Moros"
        $rif = 'v-05892464-0';

        $this->assertNull($this->rule->validate('rif', $rif, fn () => null));
    }

    public function testItWillValidateUsingClass()
    {
        // Valid RIF of "Universidad de Carabobo"
        $this->assertEquals(['rif' => 'G-20000041-4'], $this->validator->make(
           ['rif' => 'G-20000041-4'],
           ['rif' => new Rif],
        )->validate());

        // Valid RIF of "Banesco Banco Universal"
        $this->assertEquals(['rif' => 'J-07013380-5'], $this->validator->make(
            ['rif' => 'J-07013380-5'],
            ['rif' => new Rif],
        )->validate());

        // Valid RIF of "Nicolas Maduro Moros"
        $this->assertEquals(['rif' => 'V-05892464-0'], $this->validator->make(
            ['rif' => 'V-05892464-0'],
            ['rif' => new Rif],
        )->validate());
    }

    public function testItWillValidateUsingShortname()
    {
        // Valid RIF of "Universidad de Carabobo"
        $this->assertEquals(['rif' => 'G-20000041-4'], $this->validator->make(
           ['rif' => 'G-20000041-4'],
           ['rif' => 'rif'],
        )->validate());

        // Valid RIF of "Banesco Banco Universal"
        $this->assertEquals(['rif' => 'J-07013380-5'], $this->validator->make(
            ['rif' => 'J-07013380-5'],
            ['rif' => 'rif'],
        )->validate());

        // Valid RIF of "Nicolas Maduro Moros"
        $this->assertEquals(['rif' => 'V-05892464-0'], $this->validator->make(
            ['rif' => 'V-05892464-0'],
            ['rif' => 'rif'],
        )->validate());
    }
}
