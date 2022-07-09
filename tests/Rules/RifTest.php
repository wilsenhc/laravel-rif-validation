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

    /** @test */
    public function it_will_return_true_if_rif_is_valid()
    {
        // Valid RIF of "Universidad de Carabobo"
        $rif = 'G-20000041-4';

        $this->assertTrue($this->rule->passes('rif', $rif));

        // Valid RIF of "Banesco Banco Universal"
        $rif = 'J-07013380-5';

        $this->assertTrue($this->rule->passes('rif', $rif));

        // Valid RIF of "Nicolas Maduro Moros"
        $rif = 'V-05892464-0';

        $this->assertTrue($this->rule->passes('rif', $rif));
    }

    /** @test */
    public function it_will_return_false_if_format_is_invalid()
    {
        // Starts with a RIF Type that doesn't exist
        $rif = 'Q-00000000-0';

        $this->assertFalse($this->rule->passes('rif', $rif));

        // Extra number
        $rif = 'G-200000041-4';

        $this->assertFalse($this->rule->passes('rif', $rif));

        // Missing numbers
        $rif = 'V-5892464';

        $this->assertFalse($this->rule->passes('rif', $rif));

        // Letter where there should be only numbers
        $rif = 'G-200F00041-F';

        $this->assertFalse($this->rule->passes('rif', $rif));
    }

    /** @test */
    public function it_will_convert_values_to_uppercase_before_testing()
    {
        // Valid RIF of "Universidad de Carabobo"
        $rif = 'g-20000041-4';

        $this->assertTrue($this->rule->passes('rif', $rif));

        // Valid RIF of "Banesco Banco Universal"
        $rif = 'j-07013380-5';

        $this->assertTrue($this->rule->passes('rif', $rif));

        // Valid RIF of "Nicolas Maduro Moros"
        $rif = 'v-05892464-0';

        $this->assertTrue($this->rule->passes('rif', $rif));
    }

    /** @test */
    public function it_will_validate_using_class()
    {
        // Valid RIF of "Universidad de Carabobo"
        $this->assertTrue($this->validator->make(
           ['rif' => 'G-20000041-4'],
           ['rif' => new Rif],
        )->passes());

        // Valid RIF of "Banesco Banco Universal"
        $this->assertTrue($this->validator->make(
            ['rif' => 'J-07013380-5'],
            ['rif' => new Rif],
        )->passes());

        // Valid RIF of "Nicolas Maduro Moros"
        $this->assertTrue($this->validator->make(
            ['rif' => 'V-05892464-0'],
            ['rif' => new Rif],
        )->passes());
    }

    /** @test */
    public function it_will_validate_using_shortname()
    {
        // Valid RIF of "Universidad de Carabobo"
        $this->assertTrue($this->validator->make(
           ['rif' => 'G-20000041-4'],
           ['rif' => 'rif'],
        )->passes());

        // Valid RIF of "Banesco Banco Universal"
        $this->assertTrue($this->validator->make(
            ['rif' => 'J-07013380-5'],
            ['rif' => 'rif'],
        )->passes());

        // Valid RIF of "Nicolas Maduro Moros"
        $this->assertTrue($this->validator->make(
            ['rif' => 'V-05892464-0'],
            ['rif' => 'rif'],
        )->passes());
    }
}