<?php

namespace GlaivePro\Image\Tests;

use GlaivePro\Image\GPImage;
use GlaivePro\Image\Provider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
	/**
	 * Load package service providers.
	 *
	 * @param  \Illuminate\Foundation\Application $app
	 */
	protected function getPackageProviders($app): array
	{
		return [
			Provider::class,
			\Intervention\Image\ImageServiceProvider::class,
		];
	}

    protected function getPackageAliases($app): array
    {
        return [
            'GPImage' => GPImage::class,
		];
    }
}
