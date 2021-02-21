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
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->rule = new Rif();
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
}