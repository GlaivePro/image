<?php

namespace GlaivePro\Image;

use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    /**
     * Load config and routes.
     */
    public function boot(): void
    {
		$this->mergeConfigFrom(__DIR__.'/config.php', 'gpimage');

        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }
}
