# Image

Image manipulation via URLs for Laravel. It provides a URL interface, while
the manipulations themselves are done by [Intervention](https://image.intervention.io/).

The manipulated files are stored at the requested URL so the manipulation won't
be repeated, but the file will directly be served by your web server.

This package is heavily inspired by [folklore/image](https://github.com/folkloreinc/laravel-image-legacy).

## Installation

```sh
composer require glaivepro/image
```

Currently this package does not publish any config, but the manipulations are
done by intervention. In case you need to change the driver to imagick, you
should [configure intervention](https://image.intervention.io/v2/introduction/configuration#configuration-in-laravel).

## Usage

Let us consider an image that's publicly accessible as `example.com/img/some.jpg`.

This package will let you get a downsized and cropped version of this file via
the URL `example.com/img/some-image(120x150).jpg`. The manipulated image will
be stored in the `img` directory as `some-image(120x150).jpg` so that the next
request to `example.com/img/some-image(120x150).jpg` will be handled by your
web server providing the stored file.

If you want to downsize, but keep the aspect ratio, skip one of the dimensions:

- `example.com/img/some-image(200x_).jpg` — constrain width
- `example.com/img/some-image(_x90).jpg` — constrain height

Few other manipulations are available as well:

- `example.com/img/some-image(blur).jpg`
- `example.com/img/some-image(blur(10)).jpg`
- `example.com/img/some-image(pixelate(12)).jpg`
- `example.com/img/some-image(resize(120,140)).jpg` — resizing without cropping
- `example.com/img/some-image(100x200-pixelate(10)).jpg`
- `example.com/img/some-image(resize(120,140)-blur-pixelate(12)).jpg`

### Generating URLs

The simple (size constraining) URIs can be generated via our facade:

```php
$uri = GPImage::url('img/some-image.jpg', 120, 150);
// $uri is 'img/some-image-image(120x150).jpg'
```

> **Note**
> The method is named `url` for compatibility with `folklore/image`. Even
> though this is not intended as a drop-in replacement, this case will be such
> if you redefine `Image` facade alias to point to `GlaivePro\Image\GPImage`.

Full URLs can be generated via the `asset` method:

```php
$url = GPImage::asset('img/some-image.jpg', 120, 150);
// $url is 'https://example.com/img/some-image-image(120x150).jpg'
```

More complex URIs can be generated using the stringable `Uri` class:

```php
use GlaivePro\Image\Uri;

$uri = new Uri('pic.jpg');
$uri->size(20, 400);

(string) $uri; // 'pic-image(20x400).jpg'
```

Instances of `Uri` can also be produced by the `url` and `asset` methods
of the `GPImage` facade:

```php
GPImage::asset('pic.jpg')->pixelate(12)->blur(10)->resize(100, 200);
// https://example.com/pic-image(pixelate(12)-blur(10)-resize(100,200)).jpg
```

### Custom filters

You can register your own filters that will receive the intervention instance
and any arguments which you can then handle as needed:

```php
// Called via 'somepic-image(simplefilter).jpg'
GPImage::filter('simplefilter', fn ($image) => $image->anyInterventionMethod());

// Called via 'somepic-image(complexfilter(10,20))'
GPImage::filter('complexfilter', function($image, $arg1, $arg2) {
	$tempArg = $arg1 * 2;
	$image->someInterventionMethod($tempArg, $arg1);
	$image->someOtherInterventionMethod();
});
```
