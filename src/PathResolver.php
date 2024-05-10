<?php

namespace GlaivePro\Image;

use Illuminate\Http\Response;

class PathResolver
{
	public function sourcePath(string $path): string
	{
		return config('gpimage.web_files')
			? asset($path)
			: $this->fullPath($path);
	}

    public function destinationPath(string $path): string
    {
        return $this->fullPath($path);
    }

	protected function fullPath(string $path): string
	{
		return public_path($path);
	}
}
