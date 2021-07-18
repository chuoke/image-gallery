<?php

namespace Chuoke\ImageGallery\Formatters;

use Chuoke\ImageGallery\Contracts\Gallery;

class UnsplashFormatter
{
    public function format($image, Gallery $gallery)
    {
        $result = [
            'id' => $image['id'],
            'source' => $gallery->getName(),
            // 'for_date' => null,
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

    public function formatList($data, Gallery $gallery)
    {
        $images = $data['images'] ?? [];

        $result = [];
        foreach ($images as $image) {
            $result[] = $this->format($image, $gallery);
        }

        return [
            'images' => $result,
            'has_more' => $data['has_more'] ?? false,
        ];
    }
}
