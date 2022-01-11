<?php

namespace Chuoke\ImageGallery;

use Chuoke\ImageGallery\Contracts\Gallery;
use Chuoke\ImageGallery\Contracts\ResultFormatter;
use Chuoke\ImageGallery\Formatters\Formatter;
use Chuoke\ImageGallery\Params\BingListQueryParams;
use Chuoke\ImageGallery\Params\PexelsListQueryParams;
use Chuoke\ImageGallery\Params\PixabayListQueryParams;
use Chuoke\ImageGallery\Params\UnsplashListQueryParams;

class ImageGallery
{
    /**
     * @var \Chuoke\ImageGallery\Contracts\Gallery
     */
    protected $driver;

    /**
     * @var \Chuoke\ImageGallery\Contracts\ResultFormatter
     */
    protected $formatter;

    public function __construct(Gallery $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Set result formatter
     *
     * @param  mixed  $formatter
     * @return mixed
     */
    public function usingFormatter(ResultFormatter $formatter)
    {
        $this->formatter = $formatter;

        return $this;
    }

    public function format($result)
    {
        if (!$this->formatter) {
            $this->formatter = $this->defaultFormatter();
        }

        return $this->formatter->format($result, $this->driver);
    }

    public function formatList($result)
    {
        if (!$this->formatter) {
            $this->formatter = $this->defaultFormatter();
        }

        return $this->formatter->formatList($result, $this->driver);
    }

    public function defaultFormatter()
    {
        return new Formatter();
    }

    /**
     * Retrive images of gallery
     *
     * @param  mixed  $params
     * @return mixed
     */
    public function get($params)
    {
        return $this->formatList(
            $this->driver->get($this->transformListQueryParams($params))
        );
    }

    public function transformListQueryParams($params)
    {
        if (!is_array($params)) {
            return $params;
        }

        $method = 'create' . ucfirst($this->driver->getName()) . 'ListQueryParams';

        if (method_exists($this, $method)) {
            return $this->{$method}($params);
        }

        return $params;
    }

    public function createBingListQueryParams(array $params)
    {
        return new BingListQueryParams($params);
    }

    public function createPexelsListQueryParams(array $params)
    {
        return new PexelsListQueryParams($params);
    }

    public function createUnsplashListQueryParams(array $params)
    {
        return new UnsplashListQueryParams($params);
    }

    public function createPixabayListQueryParams(array $params)
    {
        return new PixabayListQueryParams($params);
    }

    /**
     * @return \Chuoke\ImageGallery\Contracts\Gallery
     */
    public function getDriver()
    {
        return $this->driver;
    }
}
