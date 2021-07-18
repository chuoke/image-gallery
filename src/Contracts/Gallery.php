<?php

namespace Chuoke\ImageGallery\Contracts;

interface Gallery
{
    /**
     * Get the gallery name.
     *
     * @return string
     */
    public function getName();

    /**
     * Get a single page from the list of all photos.
     *
     * @param  mixed  $params
     * @return array
     */
    public function get($params);
}
