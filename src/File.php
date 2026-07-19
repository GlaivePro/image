<?php

namespace GlaivePro\Image;

use Illuminate\Http\Response;
use Intervention\Image\Image as InterventionImage;
use Intervention\Image\ImageManager;

class File
{
	protected InterventionImage $image;

	public function __construct(string $path)
	{
		// Instantiated directly because on Laravel 13+ the `image`
		// container binding belongs to the framework's own
		// Intervention-v3-based component.
		$manager = new ImageManager(['driver' => config('image.driver', 'gd')]);

		$this->image = $manager->make($path);
	}

	public function store(string $path): void
	{
		$this->image->save($path);
	}

	public function apply(array $filters): void
	{
		$customFilters = GPImage::getFilters();

		foreach ($filters as $filter => $options) {
			if (false === $options)
				continue;

			$options = $this->prepareOptions($options);

			if ($customFilters[$filter] ?? false) {
				$customFilters[$filter]($this->image, ...$options);

				continue;
			}

			if (\in_array($filter, ['resize', 'blur', 'pixelate'])) {
				$this->image->$filter(...$options);

				continue;
			}

			if ('size' === $filter) {
				$this->size(...$options);

				continue;
			}
		}
	}

	public function response(): Response
	{
		return $this->image->response();
	}

	protected function size($width, $height): void
	{
		$noUpsize = static function ($constraint) {
			$constraint->upsize();
		};

		if (!$height || '_' === $height) {
			$this->image->widen($width, $noUpsize);

			return;
		}

		if (!$width || '_' === $width) {
			$this->image->heighten($height, $noUpsize);

			return;
		}

		if ($this->image->height() <= $height && $this->image->width() <= $width)
			return;

		$this->image->fit($width, $height, $noUpsize);
	}

	protected function prepareOptions($options)
	{
		if (true === $options)
			return [];

		if (!is_iterable($options))
			return [$options];

		return $options;
	}
}
