# A unified package of images for access to image sites

[![Latest Version on Packagist](https://img.shields.io/packagist/v/chuoke/image-gallery.svg?style=flat-square)](https://packagist.org/packages/chuoke/image-gallery)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/chuoke/image-gallery/Check%20&%20fix%20styling?label=code%20style)](https://github.com/chuoke/image-gallery/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/chuoke/image-gallery.svg?style=flat-square)](https://packagist.org/packages/chuoke/image-gallery)

## Installation

You can install the package via composer:

```bash
composer require chuoke/image-gallery
```

## Usage

```php

$config = [
    'default' => 'bing',

    'drivers' => [
        'pexels' => [
            'api_key' => 'your-api-key',
        ],
        'unsplash' => [
            'access_key' => 'your-access-key',
        ],
    ],
];

$imageGallery = (new \Chuoke\ImageGallery\ImageGalleryFactory($config))->gallery('pexels');

$images = $imageGallery->get();
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
