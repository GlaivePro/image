<?php

namespace GlaivePro\Image\Tests\Feature;

use GlaivePro\Image\File;
use GlaivePro\Image\Tests\TestCase;
use Illuminate\Http\Response;

class FileTest extends TestCase
{
	protected string $source = __DIR__.'/../fixtures/bilal-mansuri-_nFgGYxeGD4-unsplash.jpg';
	protected string $dest = __DIR__.'/../temp/target.jpg';

	protected function tearDown(): void
	{
		if (file_exists($this->dest))
			unlink($this->dest);

		parent::tearDown();
	}

	public function testStore(): void
	{
		$file = new File($this->source);

		$file->store($this->dest);

		$this->assertFileExists($this->dest);
	}

	public function testResponse(): void
	{
		$file = new File($this->source);

		$response = $file->response();

		$this->assertInstanceOf(Response::class, $response);
	}

	public function testApply(): void
	{
		$file = new File($this->source);
		$file->apply([
			'resize' => [100, 200],
		]);
		$file->store($this->dest);

		$destSize = getimagesize($this->dest);

		$this->assertSame(100, $destSize[0]);
		$this->assertSame(200, $destSize[1]);
	}

	public function testWidthConstraining(): void
	{
		$file = new File($this->source);
		$file->apply([
			'size' => [
				'width' => 100,
				'height' => '_',
			],
		]);
		$file->store($this->dest);

		$sourceSize = getimagesize($this->source);
		$destSize = getimagesize($this->dest);

		// Constraining width
		$this->assertSame(100, $destSize[0]);

		// Keeping aspect ratio
		$this->assertSame(
			$sourceSize[0] / $sourceSize[1],
			$destSize[0] / $destSize[1],
		);
	}

	public function testHeightConstraining(): void
	{
		$file = new File($this->source);
		$file->apply([
			'size' => [
				'width' => '_',
				'height' => 100,
			],
		]);
		$file->store($this->dest);

		$sourceSize = getimagesize($this->source);
		$destSize = getimagesize($this->dest);

		// Constraining height
		$this->assertSame(100, $destSize[1]);

		// Keeping aspect ratio
		$this->assertSame(
			$sourceSize[0] / $sourceSize[1],
			$destSize[0] / $destSize[1],
		);
	}

	public function testFitting(): void
	{
		$file = new File($this->source);
		$file->apply([
			'size' => [
				'width' => 200,
				'height' => 100,
			],
		]);
		$file->store($this->dest);

		$destSize = getimagesize($this->dest);

		// Constraining height and width
		$this->assertSame(200, $destSize[0]);
		$this->assertSame(100, $destSize[1]);
	}

	public function testNotUpsizing(): void
	{
		$file = new File($this->source);
		$file->apply([
			'size' => [
				'width' => 20000,
				'height' => 10000,
			],
		]);
		$file->store($this->dest);

		$sourceSize = getimagesize($this->source);
		$destSize = getimagesize($this->dest);

		// Constraining height and width
		$this->assertSame($sourceSize[0], $destSize[0]);
		$this->assertSame($sourceSize[1], $destSize[1]);
	}
}
