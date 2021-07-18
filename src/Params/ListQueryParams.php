<?php

namespace Chuoke\ImageGallery\Params;

use Chuoke\ImageGallery\Contracts\ListQueryParams as ContractsListQueryParams;

abstract class ListQueryParams implements ContractsListQueryParams
{
    public function __construct(array $params)
    {
        foreach ($params as $key => $val) {
            if (property_exists($this, $key)) {
                $this->{$key} = $val;
            }
        }
    }
}
