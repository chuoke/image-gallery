<?php

namespace Chuoke\ImageGallery\Exceptions;

use Exception;

class ImageGalleryRequestErrorException extends Exception
{
    public function __construct($message = 'Image gallery request failed.', $code = 500)
    {
        parent::__construct($message, $code);
    }
}
