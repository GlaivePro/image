<?php

namespace GlaivePro\Image;

class Uri
{
	use Manipulations;

	protected string $uri;
	protected ?array $size = null;
	protected array $options = [];

	public function __construct(string $path)
	{
		// Create 'img/myimage-({options}).png' from 'img/myimage.png';
		$this->uri = substr_replace(
			$path,
			config('gpimage.url_parameter'),
			strrpos($path, '.'),
			0
		);
	}

	public function __toString(): string
	{
		return str_replace(
			'{options}',
			$this->optionString(),
			$this->uri,
		);
	}

	protected function optionString(): string
	{
		$options = [];

		// Special size syntax as it has a special handling.
		if ($this->size) {
			$width = $this->size['width'] ?? '_';
			$height = $this->size['height'] ?? '_';

			$options[] = $width.'x'.$height;
		}

		foreach ($this->options as $option => $value) {
			if (true === $value)
				$options[] = $option;
			else if (is_array($value))
				$options[] = $option.'('.implode(',', $value).')';
			else
				$options[] = $option.'('.$value.')';
		}

		return implode('-', $options);
	}
}
