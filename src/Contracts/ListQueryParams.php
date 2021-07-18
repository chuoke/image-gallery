<?php

namespace Chuoke\ImageGallery\Contracts;

interface ListQueryParams
{
    /**
     * Build params of list query
     *
     * @return array
     */
    public function build();
}
