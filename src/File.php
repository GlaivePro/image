<?php

namespace GlaivePro\Image;

use Illuminate\Http\Response;
use Intervention\Image\Facades\Image as Intervention;
use Intervention\Image\Image as InterventionImage;

class File
{
	protected InterventionImage $image;

	public function __construct(string $path)
	{
		$this->image = Intervention::make($path);
	}

	public function store(string $path): void
	{
		$this->image->save($path);
	}

	public function apply(array $filters): void
	{
		foreach ($filters as $filter => $options) {
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
		$noUpsize = function ($constraint) {
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
}
