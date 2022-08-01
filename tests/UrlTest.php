<?php

namespace GlaivePro\Image\Tests;

use GlaivePro\Image\Uri;

class UrlTest extends TestCase
{
	public function testUrlGeneration(): void
	{
		$image = app('gpimage');

		$this->assertInstanceOf(Uri::class, $image->url('asdf.png'));

		$this->assertEquals(
			'pic-image(20x400).jpg',
			$image->url('pic.jpg', 20, 400)
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
}
