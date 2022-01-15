<?php

namespace Chuoke\ImageGallery\Contracts;

interface ResultFormatter
{
    /**
     * Format one single image result.
     *
     * @param  mixed  $image
     * @return mixed
     */
    public function format($image);

    /**
     * Format image list result.
     *
     * @param  mixed  $data
     * @return mixed
     */
    public function formatList($data);
}
