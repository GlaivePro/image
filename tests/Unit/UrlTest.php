<?php

namespace GlaivePro\Image\Tests\Unit;

use GlaivePro\Image\Tests\TestCase;
use GlaivePro\Image\Uri;

class UrlTest extends TestCase
{
	public function testUriClass(): void
	{
		$uri = new Uri('pic.jpg');

		$this->assertEquals(
			'pic-image(20x400-blur-pixelate(12)).jpg',
			$uri->size(20, 400)->blur()->pixelate(12)
		);
	}

	public function testUrlGeneration(): void
	{
		$image = app('gpimage');

		$this->assertInstanceOf(Uri::class, $image->url('asdf.png'));

		$this->assertEquals(
			'pic-image(20x400).jpg',
			$image->url('pic.jpg', 20, 400)
		);

		$this->assertEquals(
			'pic-image(20x_).jpg',
			$image->url('pic.jpg', 20)
		);

		$this->assertEquals(
			'pic-image(_x400).jpg',
			$image->url('pic.jpg', null, 400)
		);

		$this->assertEquals(
			'pic-image(_x400).jpg',
			$image->url('pic.jpg', height: 400)
		);

		$this->assertEquals(
			'pic-image(20x400).jpg',
			$image->url('pic.jpg')->size(20, 400)
		);

		$this->assertEquals(
			'pic-image(20x400-blur-pixelate(12)).jpg',
			$image->url('pic.jpg')->size(20, 400)->blur()->pixelate(12)
		);

		$this->assertEquals(
			'pic-image(pixelate(12)-blur(10)-resize(100,200)).jpg',
			$image->url('pic.jpg')->pixelate(12)->blur(10)->resize(100, 200)
		);
	}

	public function testFullUrlGeneration(): void
	{
		$image = app('gpimage');
		config(['app.asset_url' => 'https://example.com']);

		$this->assertInstanceOf(Uri::class, $image->asset('asdf.png'));

		$this->assertEquals(
			'https://example.com/pic-image(20x400).jpg',
			$image->asset('pic.jpg', 20, 400)
		);
	}
}
