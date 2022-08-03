<?php

namespace GlaivePro\Image\Tests\Unit;

use GlaivePro\Image\File;
use GlaivePro\Image\Tests\TestCase;
use Mockery;
use Mockery\MockInterface;

class CustomFilterTest extends TestCase
{
	protected string $file = __DIR__.'/../fixtures/bilal-mansuri-_nFgGYxeGD4-unsplash.jpg';

	public function testRegistration(): void
	{
		$image = app('gpimage');

		$this->assertSame(0, \count($image->getFilters()));

		$image->filter('myfilter', fn() => true);

		$this->assertSame(1, \count($image->getFilters()));
	}

	public function testCallback(): void
	{
		$file = new File($this->file);

		$image = app('gpimage');

		$mock = $this->mock(\stdClass::class, function (MockInterface $mock) {
			$mock->shouldReceive('called')
				->once()
				->with(\Mockery::on(function ($int): bool {
					return ($int instanceof \Intervention\Image\Image);
				}), 'a', 'b');
		});

		// Change [$mock, 'called'] to $mock->called(...) if PHP8.0 support is dropped.
		$image->filter('myfilter', [$mock, 'called']);

		$file->apply([
			'myfilter' => ['a', 'b'],
		]);
	}
}
