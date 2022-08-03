<?php

namespace GlaivePro\Image\Tests\Feature;

use GlaivePro\Image\File;
use GlaivePro\Image\GPImage;
use GlaivePro\Image\Tests\TestCase;
use Illuminate\Http\Response;

class IntegrationTest extends TestCase
{
	public function testRetrieval(): void
	{
		$uri = 'bilal-mansuri-_nFgGYxeGD4-unsplash-image(100x_).jpg';

		$response = $this->get($uri)
			->assertOk();

		$this->assertSame(file_get_contents(public_path($uri)), $response->getContent());

		unlink(public_path($uri));
	}

	public function testComplexRetrieval(): void
	{
		$uri = 'bilal-mansuri-_nFgGYxeGD4-unsplash-image(100x_-blur(2)-pixelate).jpg';

		$response = $this->get($uri)
			->assertOk();

		$this->assertSame(file_get_contents(public_path($uri)), $response->getContent());

		unlink(public_path($uri));
	}

	public function testRetrievalWithoutSize(): void
	{
		$uri = 'bilal-mansuri-_nFgGYxeGD4-unsplash-image(blur(2)-resize(200,300)).jpg';

		$response = $this->get($uri)
			->assertOk();

		$this->assertSame(file_get_contents(public_path($uri)), $response->getContent());

		unlink(public_path($uri));
	}

	public function testRetrievingFromCreatedUrl(): void
	{
		$path = 'bilal-mansuri-_nFgGYxeGD4-unsplash.jpg';
		$uri = GPImage::url($path, 100, 200);

		$response = $this->get($uri)
			->assertOk();

		$this->assertSame(file_get_contents(public_path($uri)), $response->getContent());

		unlink(public_path($uri));
	}
}
