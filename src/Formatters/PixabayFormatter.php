<?php

namespace Chuoke\ImageGallery\Formatters;

use Chuoke\ImageGallery\Driver\Pixabay;

class PixabayFormatter
{
    /**
     * The current gallery driver.
     *
     * @var \Chuoke\ImageGallery\Driver\Pixabay
     */
    protected $gallery;

    public function __construct(Pixabay $gallery)
    {
        $this->gallery = $gallery;
    }

    public function formatList($data)
    {
        $result = [];
        foreach ($data as $image) {
            $result[] = $this->format($image);
        }

        return $result;
    }

    public function format($image)
    {
        if ($this->gallery->isVideo()) {
            return $this->formatVideo($image);
        }

        return $this->formatImage($image);
    }

    public function formatImage($image)
    {
        $result = [
            'id' => $image['id'],
            'source' => $this->gallery->getName(),
            'type' => $image['type'],
            'tags' => array_filter(explode(',', $image['tags'] ?? '')),
            'title' => '',
            'copyrighter' => $image['user'],
            'copyright_link' => $image['pageURL'],
            'width' => $image['width'] ?? '',
            'height' => $image['height'] ?? '',
            'color' => '',
            'size' => $image['imageURL'],
            'url' => $image['webformatURL'],
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

            if (!array_key_exists($realFiled, $image)) {
                continue;
            }

            $result['urls'][] = [
                'type' => $key,
                'url' => $image[$realFiled],
            ];

            if ($key !== 'vector') {
                $result['width'] = $image[$field . 'Width'] ?? $result['width'];
                $result['height'] = $image[$field . 'Height'] ?? $result['height'];
                $result['url'] = $image[$realFiled];
            }
        }

        return $result;
    }

    public function formatVideo($video)
    {
        $result = [
            'id' => $video['id'],
            'source' => $this->gallery->getName(),
            'type' => $video['type'],
            'tags' => array_filter(explode(',', $video['tags'] ?? '')),
            'title' => '',
            'copyrighter' => $video['user'],
            'copyright_link' => $video['pageURL'],

            'width' => '',
            'height' => '',
            'size' => '',
            'url' => '',
            'preveiw' => $video['videos']['tiny']['url'],
            'urls' => [],
            'duration' => $video['duration'],
            'color' => '',
        ];

        foreach ($video['videos'] as $type => $val) {
            if (0 >= $val['size']) {
                continue;
            }

            $result['urls'][] = [
                'type' => $type,
                'url' => $val['url'],
                'width' => $val['width'],
                'height' => $val['height'],
                'size' => $val['size'],
            ];
        }

        $original = $result['urls'][0] ?? [];
        unset($result['type']);

        return array_merge($result, $original);
    }
}
