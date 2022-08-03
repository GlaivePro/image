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

	/**
	 * Load package aliases.
	 *
	 * @param  \Illuminate\Foundation\Application $app
	 */
	protected function getPackageAliases($app): array
	{
		return [
			'GPImage' => GPImage::class,
		];
	}

	/**
	 * Load package service providers.
	 *
	 * @param  \Illuminate\Foundation\Application $app
	 */
    protected function getEnvironmentSetUp($app): void
    {
        $app->instance('path.public', __DIR__.'/fixtures');
    }
}
