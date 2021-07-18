<?php

namespace Chuoke\ImageGallery\Formatters;

use Chuoke\ImageGallery\Contracts\Gallery;
use Chuoke\ImageGallery\Contracts\ResultFormatter;

class Formatter implements ResultFormatter
{
    /**
     * Format one single image result.
     *
     * @param  mixed  $image
     * @param  Gallery  $gallery
     * @return mixed
     */
    public function format($image, Gallery $gallery)
    {
        switch ($gallery->getName()) {
            case 'bing':
                return (new BingFormatter())->format($image, $gallery);
            case 'pexels':
                return (new PexelsFormatter())->format($image, $gallery);
            case 'unsplash':
                return (new UnsplashFormatter())->format($image, $gallery);
        }

        return $image;
    }

    /**
     * Format image list result.
     *
     * @param  mixed  $images
     * @param  Gallery  $gallery
     * @return mixed
     */
    public function formatList($data, Gallery $gallery)
    {
        switch ($gallery->getName()) {
            case 'bing':
                return (new BingFormatter())->formatList($data, $gallery);
            case 'pexels':
                return (new PexelsFormatter())->formatList($data, $gallery);
            case 'unsplash':
                return (new UnsplashFormatter())->formatList($data, $gallery);
        }

        return $data;
    }
}
