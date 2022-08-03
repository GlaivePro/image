<?php

namespace GlaivePro\Image;

use Illuminate\Http\Response;

class Controller
{
	/**
	 * Get and serve the requested image.
	 */
	public function __invoke(string $uri): Response
	{
		preg_match('~'.GPImage::pattern().'~', $uri, $matches);

		$path = $this->fullPath($matches[1].'.'.$matches[3]);
		$filters = $this->filters($matches[2]);

		$image = app(File::class, ['path' => $path]);
		$image->apply($filters);
		$image->store($this->fullPath($uri));

		return $image->response();
	}

	protected function filters(string $optString): array
	{
		$filters = [];

		foreach (explode('-', $optString) as $option) {
			if (preg_match('/^([0-9]+)$/', $option, $matches)) {
				$filters['size'] = [
					'width' => $matches[1],
					'height' => '_',
				];

				continue;
			}

			if (preg_match('/^([0-9]+|_)x([0-9]+|_)$/', $option, $matches)) {
				$filters['size'] = [
					'width' => $matches[1],
					'height' => $matches[2],
				];

				continue;
			}

			if (preg_match('/(\w+)(?:\(([\w,.]+)\))?/', $option, $matches)) {
				$filter = $matches[1];

				if (isset($matches[2])) {
					$filters[$filter] = strpos($matches[2], ',') ? explode(',', $matches[2]) : $matches[2];
				} else
					$filters[$filter] = true;
			}
		}

		return $filters;
	}

	protected function fullPath($path)
	{
		return public_path($path);
	}
}
