<?php

namespace Chuoke\ImageGallery\Formatters;

use Chuoke\ImageGallery\Contracts\Gallery;

class PexelsFormatter
{
    public function format($image, Gallery $gallery)
    {
        $result = [
            'id' => $image['id'],
            'source' => $gallery->getName(),
            // 'for_date' => null,
            'title' => '',
            'copyrighter' => $image['photographer'],
            'copyright_link' => $image['url'],
            'width' => $image['width'],
            'height' => $image['height'],
            'color' => $image['avg_color'],
            'url' => $image['src']['original'],
            'thumb' => $image['src']['small'],
            'urls' => [],
        ];

        foreach ($image['src'] as $type => $url) {
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
