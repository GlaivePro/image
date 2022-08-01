<?php

namespace GlaivePro\Image;

/**
 * Most of the methods register an Intervention manipulation.
 *
 * TODO: Add other Intervention's manipulations as needed.
 */
trait Manipulations
{
	/**
	 * Magic manipulation that will use `fit+downsize` when both dimensions are
	 * given and downsize with a fixed aspect ratio otherwise.
	 */
	public function size($width, $height): self
	{
		$this->size = compact('width', 'height');

		return $this;
	}

	public function blur(int $amount = null): self
	{
		if ($amount)
			$this->options['blur'] = $amount;
		else
			$this->options['blur'] = true;

		return $this;
	}

	public function pixelate(int $size): self
	{
		$this->options['pixelate'] = $size;

		return $this;
	}

	public function resize(int $width, int $height): self
	{
		$this->options['resize'] = compact('width', 'height');

		return $this;
	}
}
