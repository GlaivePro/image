<?php

namespace GlaivePro\Image\Tests;

use GlaivePro\Image\Provider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Load package service providers.
     * @param  \Illuminate\Foundation\Application $app
     */
    protected function getPackageProviders($app): array
    {
        return [Provider::class];
    }
}
