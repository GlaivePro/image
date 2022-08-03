<?php

namespace GlaivePro\Image;

class Image
{
	protected $filters = [];

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

	/**
	 * Get a stringable image Url and optionally set size.
	 */
	public function asset(string $path, int $width = null, int $height = null): Uri
	{
		$fullPath = asset($path);

		return $this->url($fullPath, $width, $height);
	}

	/**
	 * Register a custom handler.
	 */
	public function filter(string $key, callable $filter): void
	{
		$this->filters[$key] = $filter;
	}

	public function getFilters(): array
	{
		return $this->filters;
	}

	// Routing pattern is based on the implementation by folklore/image
	// https://github.com/folkloreinc/laravel-image-legacy/blob/1da1a4fc6df9158e29dd5d347104f6376c169eab/src/Folklore/Image/ImageManager.php#L420
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
