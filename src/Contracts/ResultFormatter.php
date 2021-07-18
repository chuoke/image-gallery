<?php

namespace Chuoke\ImageGallery\Contracts;

interface ResultFormatter
{
    /**
     * Format one single image result.
     *
     * @param  mixed  $image
     * @param  Gallery  $gallery
     * @return mixed
     */
    public function format($image, Gallery $gallery);

    /**
     * Format image list result.
     *
     * @param  mixed  $data
     * @param  Gallery  $gallery
     * @return mixed
     */
    public function formatList($data, Gallery $gallery);
}
