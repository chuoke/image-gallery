<?php

namespace Chuoke\ImageGallery\Formatters;

use Chuoke\ImageGallery\Contracts\Gallery;

class PixabayFormatter
{
    public function format($image, Gallery $gallery)
    {
        $result = [
            'id' => $image['id'],
            'source' => $gallery->getName(),
            'type' => $image['type'],
            'tags' => $image['tags'],
            'title' => '',
            'copyrighter' => $image['user'],
            'copyright_link' => $image['pageURL'],
            'width' => $image['width'] ?? '',
            'height' => $image['height'] ?? '',
            'color' => '',
            'size' => $image['imageSize'],
            'url' => 'previewURL',
            'thumb' => $image['previewURL'],
            'urls' => [],
        ];

        $sizeMap = [
            'thumb' => 'preview',
            'medium' => 'webformat',
            'large' => 'largeImage',
            'hd' => 'fullHD',
            'original' => 'image',
            'vector' => 'vector',
        ];

        foreach ($sizeMap as $key => $field) {
            $realFiled = $field . 'URL';

            if (! array_key_exists($realFiled, $image)) {
                continue;
            }

            $result['urls'][] = [
                'type' => $key,
                'url' => $image[$realFiled],
            ];

            if ($key !== 'vecter') {
                $result['width'] = $image[$field . 'Width'] ?? $result['width'];
                $result['height'] = $image[$field . 'Height'] ?? $result['height'];
                $result['url'] = $image[$realFiled];
            }
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
