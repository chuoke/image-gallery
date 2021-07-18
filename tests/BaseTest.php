<?php

namespace Chuoke\ImageGallery\Tests;

use Chuoke\ImageGallery\ImageGalleryFactory;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
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

    /** @test */
    public function can_default_work()
    {
        $imageGallery = $this->factory()->gallery();

        $this->assertEquals($this->config()['default'], $imageGallery->getDriver()->getName());

        $data = $imageGallery->get([]);

        $this->assertArrayHasKey('images', $data);
    }

    /** @test */
    public function can_pexels_work()
    {
        $imageGallery = $this->factory()->gallery('pexels');

        $data = $imageGallery->get([]);

        $this->assertArrayHasKey('images', $data);
    }

    /** @test */
    public function can_bing_work()
    {
        $imageGallery = $this->factory()->gallery('bing');

        $data = $imageGallery->get([]);

        $this->assertArrayHasKey('images', $data);
    }

    /** @test */
    public function can_unsplash_work()
    {
        $imageGallery = $this->factory()->gallery('unsplash');

        $data = $imageGallery->get([]);

        $this->assertArrayHasKey('images', $data);
    }
}
