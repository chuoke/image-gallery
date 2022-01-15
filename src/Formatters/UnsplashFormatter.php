<?php

namespace Chuoke\ImageGallery\Formatters;

use Chuoke\ImageGallery\Contracts\Gallery;

class UnsplashFormatter
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

    public function format($image)
    {
        $result = [
            'id' => $image['id'],
            'source' => $this->gallery->getName(),
            'title' => $image['alt_description'] ?: $image['description'],
            'copyrighter' => $image['user']['name'],
            'copyright_link' => $image['links']['html'],
            'width' => $image['width'],
            'height' => $image['height'],
            'color' => $image['color'],
            'url' => $image['urls']['raw'],
            'thumb' => $image['urls']['small'],
            'urls' => [],
        ];

        foreach ($image['urls'] as $type => $url) {
            $result['urls'][] = [
                'url' => $url,
                'type' => $type,
            ];
        }

        return $result;
    }

    public function formatList($data)
    {
        $result = [];
        foreach ($data as $image) {
            $result[] = $this->format($image);
        }

        return $result;
    }
}
