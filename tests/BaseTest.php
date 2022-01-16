<?php

namespace Chuoke\ImageGallery\Tests;

use Chuoke\ImageGallery\ImageGalleryFactory;

trait BaseTest
{
    protected $factory;

    protected function config()
    {
        return include './tests/config.php';
    }

    /**
     * @return \Chuoke\ImageGallery\ImageGalleryFactory
     */
    protected function factory()
    {
        if ($this->factory) {
            return $this->factory;
        }

        return $this->factory = new ImageGalleryFactory($this->config());
    }
}
