<?php

namespace Chuoke\ImageGallery\Formatters;

use Chuoke\ImageGallery\Driver\AbstractGallery as Gallery;

class BingFormatter
{
    public function format($image, Gallery $gallery)
    {
        $titleAndCopyrighter = $this->parseTitleAndCopyrighter($image['copyright']);

        foreach (['url', 'copyrightlink',] as $field) {
            if (! empty($image[$field]) && strpos($image[$field], 'http') !== 0) {
                $image[$field] = implode('/', [$gallery->baseUrl(), ltrim($image[$field], '/')]);
            }
        }

        return [
            'id' => $image['hsh'],
            'source' => $gallery->getName(),
            'for_date' => date('Y-m-d', strtotime($image['startdate'])),
            'title' => $titleAndCopyrighter['title'] ?: $image['title'],
            'copyrighter' => $titleAndCopyrighter['copyrighter'] ?: $image['copyright'],
            'copyright_link' => $image['copyrightlink'],
            'url' => $image['url'],
            'thumb' => $image['url'],
            'urls' => [
                [
                    'url' => $image['url'],
                    'type' => 'thumb',
                ],
            ],
        ];
    }

    public function parseTitleAndCopyrighter($str)
    {
        $matches = [];

        $splited = [];
        if (preg_match('/\(©(.*)\)/', $str, $matches) && count($matches) >= 2) {
            $splited = [
                'title' => str_replace($matches[0], '', $str),
                'copyrighter' => $matches[1],
            ];
        }

        return $splited;
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
