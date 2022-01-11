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
        if ($formatter = $this->createFormtter($gallery)) {
            return $formatter->format($image, $gallery);
        }

        return $image;
    }

    /**
     * Format image list result.
     *
     * @param  mixed  $data
     * @param  Gallery  $gallery
     * @return mixed
     */
    public function formatList($data, Gallery $gallery)
    {
        if ($formatter = $this->createFormtter($gallery)) {
            return $formatter->formatList($data, $gallery);
        }

        return $data;
    }

    protected function createFormtter(Gallery $gallery)
    {
        switch ($gallery->getName()) {
            case 'bing':
                return new BingFormatter();
            case 'pexels':
                return new PexelsFormatter();
            case 'unsplash':
                return new UnsplashFormatter();
            case 'pixabay':
                return new PixabayFormatter();
        }

        return null;
    }
}
