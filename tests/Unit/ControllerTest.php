<?php

namespace GlaivePro\Image\Tests\Unit;

use GlaivePro\Image\File;
use GlaivePro\Image\Tests\TestCase;
use Mockery;
use Mockery\MockInterface;

class ControllerTest extends TestCase
{
	public function testPath(): void
	{
		$mock = Mockery::mock(File::class, function(MockInterface $file) {
			$file->shouldReceive('store');
			$file->shouldReceive('apply');
			$file->shouldReceive('response')->andReturn(response('123'));
		});

		app()->bind(File::class, function($app, $args) use ($mock) {
			$this->assertSame(public_path('dir/something.jpg'), $args['path']);

			return $mock;
		});

		$this->get('dir/something-image().jpg')
			->assertOk();
	}

	public function testStore(): void
	{
		$mock = Mockery::mock(File::class, function(MockInterface $file) {
			$file->expects()->store(public_path('dir/something-image().jpg'));
			$file->shouldReceive('apply');
			$file->shouldReceive('response')->andReturn(response('123'));
		});

		app()->bind(File::class, fn() => $mock);

		$this->get('dir/something-image().jpg')
			->assertOk();
	}

	public function testFilters(): void
	{
		$mock = Mockery::mock(File::class, function(MockInterface $file) {
			$file->shouldReceive('store');
			$file->expects()->apply([
				'size' => [
					'width' => '12',
					'height' => '20',
				],
				'crop' => true,
				'blur' => '2',
				'resize' => ['3', '4'],
			]);
			$file->shouldReceive('response')->andReturn(response('123'));
		});

		app()->bind(File::class, fn() => $mock);

		$this->get('dir/something-image(12x20-crop-blur(2)-resize(3,4)).jpg')
			->assertOk();
	}
}
