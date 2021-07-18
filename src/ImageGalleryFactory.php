<?php

namespace Chuoke\ImageGallery;

use Chuoke\ImageGallery\Contracts\Gallery;
use Chuoke\ImageGallery\Driver\Bing;
use Chuoke\ImageGallery\Driver\Pexels;
use Chuoke\ImageGallery\Driver\Unsplash;
use InvalidArgumentException;

class ImageGalleryFactory
{
    /**
     * The array of resolved gallery drivers.
     *
     * @var array
     */
    protected $galleries = [];

    /**
     * The registered custom driver creators.
     *
     * @var array
     */
    protected $customCreators = [];

    /**
     * Configure of drivers.
     *
     * @var array
     */
    protected $config;

    /**
     * Create a new gallery manager instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Get a ImageGallery instance.
     *
     * @param  string|null  $name
     * @return \Chuoke\ImageGallery\ImageGallery
     */
    public function gallery($name = null)
    {
        $name = $name ?: $this->getDefaultGallery();

        return $this->galleries[$name] = $this->get($name);
    }

    /**
     * Get a gallery instance.
     *
     * @param  string|null  $name
     * @return \Chuoke\ImageGallery\ImageGallery
     */
    public function driver($name = null)
    {
        return $this->gallery($name);
    }

    /**
     * Attempt to get the disk from the local cache.
     *
     * @param  string  $name
     * @return \Chuoke\ImageGallery\ImageGallery
     */
    protected function get($name)
    {
        return $this->galleries[$name] ?? $this->resolve($name);
    }

    /**
     * Resolve the given disk.
     *
     * @param  string  $name
     * @return \Chuoke\ImageGallery\ImageGallery
     *
     * @throws \InvalidArgumentException
     */
    protected function resolve($name)
    {
        $config = $this->getConfig($name);

        if (isset($this->customCreators[$name])) {
            return $this->callCustomCreator($config);
        }

        $driverMethod = 'create' . ucfirst($name) . 'Driver';

        if (! method_exists($this, $driverMethod)) {
            throw new InvalidArgumentException("Driver [{$name}] is not supported.");
        }

        return $this->{$driverMethod}($config);
    }

    /**
     * Call a custom driver creator.
     *
     * @param  array  $config
     * @return \Chuoke\ImageGallery\ImageGallery
     */
    protected function callCustomCreator(array $config)
    {
        $driver = $this->customCreators[$config['driver']]($config);

        return $driver;
    }

    /**
     * Create an instance of the Bing gallery driver.
     *
     * @param  array  $config
     * @return \Chuoke\ImageGallery\ImageGallery
     */
    public function createBingDriver(array $config)
    {
        return $this->makeGallery(new Bing($config));
    }

    /**
     * Create an instance of the Pexels gallery driver.
     *
     * @param  array  $config
     * @return \Chuoke\ImageGallery\ImageGallery
     */
    public function createPexelsDriver(array $config)
    {
        return $this->makeGallery(new Pexels($config));
    }

    /**
     * Create an instance of the Unsplash gallery driver.
     *
     * @param  array  $config
     * @return \Chuoke\ImageGallery\ImageGallery
     */
    public function createUnsplashDriver(array $config)
    {
        return $this->makeGallery(new Unsplash($config));
    }

    /**
     * Create a new cache repository with the given implementation.
     *
     * @param  \Chuoke\ImageGallery\Contracts\Gallery  $gallery
     * @return \Chuoke\ImageGallery\ImageGallery
     */
    public function makeGallery(Gallery $gallery)
    {
        return new ImageGallery($gallery);
    }

    /**
     * Get the ImageGallery connection configuration.
     *
     * @param  string  $name
     * @return array
     */
    protected function getConfig($name)
    {
        $drivers = $this->config['drivers'] ?? [];

        return $drivers[$name] ?? $this->config;
    }

    /**
     * Get the default driver name.
     *
     * @return string|null
     */
    public function getDefaultGallery()
    {
        return $this->config['default'] ?? null;
    }

    /**
     * Dynamically call the default driver instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->gallery()->$method(...$parameters);
    }
}
