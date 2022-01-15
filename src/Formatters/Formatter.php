<?php

namespace Chuoke\ImageGallery\Formatters;

use Chuoke\ImageGallery\Contracts\Gallery;
use Chuoke\ImageGallery\Contracts\ResultFormatter;

class Formatter implements ResultFormatter
{
    /**
     * The current gallery driver.
     *
     * @var \Chuoke\ImageGallery\Contracts\Gallery
     */
    protected $gallery;

    public function __construct(Gallery $gallery)
    {
        $this->gallery = $gallery;
    }

    /**
     * Format one single image result.
     *
     * @param  mixed  $image
     * @param  Gallery  $gallery
     * @return mixed
     */
    public function format($image)
    {
        if ($formatter = $this->createFormtter($this->gallery)) {
            return $formatter->format($image);
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
    public function formatList($data)
    {
        if ($formatter = $this->createFormtter($this->gallery)) {
            return $formatter->formatList($data);
        }

        return $data;
    }

    protected function createFormtter(Gallery $gallery)
    {
        switch ($gallery->getName()) {
            case 'bing':
                return new BingFormatter($gallery);
            case 'pexels':
                return new PexelsFormatter($gallery);
            case 'unsplash':
                return new UnsplashFormatter($gallery);
            case 'pixabay':
                return new PixabayFormatter($gallery);
        }

        return null;
    }
}
