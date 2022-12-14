<?php

namespace GlaivePro\Image;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \GlaivePro\Image\Uri url(string $path, int $width = null, int $height = null) Get a stringable image Uri and optionally set size.
 * @method static \GlaivePro\Image\Uri asset(string $path, int $width = null, int $height = null) Get a stringable image Url and optionally set size.
 * @method static void filter(string $key, callable $filter) Register a custom handler.
 *
 * @see \GlaivePro\Image\Image
 */
class GPImage extends Facade
{
	protected static function getFacadeAccessor(): string
	{
		return 'gpimage';
	}
}
