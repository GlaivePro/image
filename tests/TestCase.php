<?php

namespace GlaivePro\Image\Tests;

use GlaivePro\Image\GPImage;
use GlaivePro\Image\Provider;
use Illuminate\Testing\Assert;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
	/**
	 * Load package service providers.
	 *
	 * @param  \Illuminate\Foundation\Application $app
	 */
	protected function getPackageProviders($app): array
	{
		return [
			Provider::class,
			\Intervention\Image\ImageServiceProvider::class,
		];
	}

	/**
	 * Load package aliases.
	 *
	 * @param  \Illuminate\Foundation\Application $app
	 */
	protected function getPackageAliases($app): array
	{
		return [
			'GPImage' => GPImage::class,
		];
	}

	/**
	 * Load package service providers.
	 *
	 * @param  \Illuminate\Foundation\Application $app
	 */
	protected function getEnvironmentSetUp($app): void
	{
		$app->instance('path.public', __DIR__.'/fixtures');
	}

	/**
     * For compatibility with Laravel 8 and Laravel 9-prefer-lowest.
	 * Taken directly from:
	 * https://github.com/laravel/framework/blob/87d1da43ca53cd59f00df552466c7540fffeab25/src/Illuminate/Foundation/Testing/Concerns/InteractsWithExceptionHandling.php#L161
     */
    protected function assertThrows(\Closure $test, string $expectedClass = \Throwable::class, ?string $expectedMessage = null): self
    {
        try {
            $test();

            $thrown = false;
        } catch (\Throwable $exception) {
            $thrown = $exception instanceof $expectedClass;

            $actualMessage = $exception->getMessage();
        }

        Assert::assertTrue(
            $thrown,
            sprintf('Failed asserting that exception of type "%s" was thrown.', $expectedClass)
        );

        if (isset($expectedMessage)) {
            if (! isset($actualMessage)) {
                Assert::fail(
                    sprintf(
                        'Failed asserting that exception of type "%s" with message "%s" was thrown.',
                        $expectedClass,
                        $expectedMessage
                    )
                );
            } else {
                Assert::assertStringContainsString($expectedMessage, $actualMessage);
            }
        }

        return $this;
    }
}
