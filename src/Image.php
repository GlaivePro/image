<?php

namespace GlaivePro\Image;

class Image
{
	/**
	 * Get a stringable image Uri and optionally set size.
	 */
	public function url(string $path, int $width = null, int $height = null): Uri
	{
		$uri = new Uri($path);

		if ($width || $height)
			$uri->size($width, $height);

		return $uri;
	}
}
