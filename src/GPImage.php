<?php

namespace GlaivePro\Image;

use Illuminate\Support\Facades\Facade;

class GPImage extends Facade
{
	protected static function getFacadeAccessor(): string
	{
		return 'gpimage';
	}
}
