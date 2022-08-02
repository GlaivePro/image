<?php

namespace GlaivePro\Image\Tests\Unit;

use GlaivePro\Image\File;
use GlaivePro\Image\Tests\TestCase;
use Mockery;
use Mockery\MockInterface;

class RouteTest extends TestCase
{
	public function testRouteMatches(): void
	{
		$mock = Mockery::mock(File::class, function(MockInterface $file) {
			$file->shouldReceive('store');
			$file->shouldReceive('apply');
			$file->shouldReceive('response')->andReturn(response('123'));
		});

		app()->bind(File::class, fn() => $mock);

		$this->get('something-image().jpg')
			->assertOk();

		$this->get('dir/something-image().jpg')
			->assertOk();

		$this->get('something-image(200x400).jpg')
			->assertOk();

		$this->get('something-image(200x_).jpg')
			->assertOk();

		$this->get('something-image(200).jpg')
			->assertOk();

		$this->get('something-image(_x400).jpg')
			->assertOk();

		$this->get('something-image(200x400-crop).jpg')
			->assertOk();

		$this->get('something-image(200x_-crop).jpg')
			->assertOk();

		$this->get('something-image(_x400-crop).jpg')
			->assertOk();
	}

	public function testOtherRoutesDoNotMatch(): void
	{
		$this->get('something-image(_x400-crop).pdf')
			->assertNotFound();

		$this->get('something.jpg')
			->assertNotFound();

		$this->get('something-(_x400-crop).jpg')
			->assertNotFound();
	}
}
