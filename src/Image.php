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

	public function pattern(): string
	{
		$parameter = str_replace(
			'\{options\}',
			'([0-9a-zA-Z\(\),\-/._]+?)?',
			preg_quote(config('gpimage.url_parameter'))
		);

		return str_replace(
			'{parameters}',
			$parameter,
			config('gpimage.url_pattern')
		);
	}
}
