<?php

namespace Chuoke\ImageGallery\Driver;

use Chuoke\ImageGallery\Contracts\Gallery;
use Chuoke\ImageGallery\Exceptions\ImageGalleryRequestErrorException;
use Illuminate\Http\Client\Factory;

abstract class AbstractGallery implements Gallery
{
    /**
     * Base url
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Http request client instance
     *
     * @var \Illuminate\Http\Client\Factory
     */
    protected $http;

    /**
     * @var array
     */
    protected $configurable = [];

    public function __construct(array $config)
    {
        $this->setConfig($config);
    }

    /**
     * Set the config.
     *
     * @param array $config
     *
     * @return $this
     */
    public function setConfig(array $config)
    {
        foreach ($this->configurable as $setting) {
            if (! isset($config[$setting])) {
                continue;
            }

            $method = 'set';

            foreach (explode('_', $setting) as $word) {
                $method .= ucfirst($word);
            }

            if (method_exists($this, $method)) {
                $this->$method($config[$setting]);
            }
        }

        return $this;
    }

    /**
     * Get HTTP instance
     *
     * @return \Illuminate\Http\Client\Factory
     */
    protected function http()
    {
        return $this->makeHttp();
    }

    /**
     * @return \Illuminate\Http\Client\Factory
     */
    protected function makeHttp()
    {
        if ($this->http) {
            return $this->http;
        }

        $this->http = (new Factory())
            ->baseUrl($this->baseUrl())
            ->withHeaders($this->withHeaders())
            ->withoutVerifying();

        return $this->http;
    }

    /**
     * @return string
     */
    public function baseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @return array
     */
    protected function withHeaders()
    {
        return [];
    }

    public function getName()
    {
        return $this->name;
    }

    public function throwRequestFailedException($message, $code)
    {
        throw new ImageGalleryRequestErrorException($message, $code);
    }
}
