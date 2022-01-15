<?php

namespace Chuoke\ImageGallery\Formatters;

use Chuoke\ImageGallery\Driver\Pexels;

class PexelsFormatter
{
    /**
     * The current gallery driver.
     *
     * @var \Chuoke\ImageGallery\Driver\Pexels
     */
    protected $gallery;

    public function __construct(Pexels $gallery)
    {
        $this->gallery = $gallery;
    }

    public function formatList($data)
    {
        $result = [];
        foreach ($data as $item) {
            $result[] = $this->format($item);
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

    public function formatVideo($video)
    {
        $result = [
            'id' => $video['id'],
            'source' => $this->gallery->getName(),
            'title' => '',
            'copyrighter' => $video['user']['name'],
            'copyright_link' => $video['url'],
            'width' => $video['width'],
            'height' => $video['height'],
            'duration' => $video['duration'],
            'color' => '',
            'url' => $video['video_files'][0]['link'],
            'thumb' => $video['image'],
            'urls' => [],
        ];

        foreach ($video['video_files'] as $url) {
            $result['urls'][] = [
                'url' => $url['link'],
                'mime' => $url['file_type'],
                'width' => $url['width'],
                'height' => $url['height'],
                'type' => $url['quality'],
            ];
        }

        return $result;
    }
}
