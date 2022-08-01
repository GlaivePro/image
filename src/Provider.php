<?php

namespace GlaivePro\Image;

use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
	/**
	 * Register the services.
	 */
	public function register(): void
	{
		$this->app->singleton('gpimage', fn ($app) => $app->make(Image::class));
	}

    /**
     * Load config and routes.
     */
    public function boot(): void
    {
		$this->mergeConfigFrom(__DIR__.'/config.php', 'gpimage');

        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }
}
