<?php

namespace GlaivePro\Image\Tests;

class RouteTest extends TestCase
{
    public function testRouteMatches(): void
    {
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
