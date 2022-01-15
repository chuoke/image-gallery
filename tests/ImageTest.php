<?php

namespace Chuoke\ImageGallery\Tests;

use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    use BaseTest;

    /** @test */
    public function can_default_work()
    {
        $imageGallery = $this->factory()->gallery();

        $this->assertEquals($this->config()['default'], $imageGallery->getDriver()->getName());

        $data = $imageGallery->get([]);

        $this->assertArrayHasKey('data', $data);
    }

    /** @test */
    public function can_pexels_work()
    {
        $imageGallery = $this->factory()->gallery('pexels');

        $data = $imageGallery->get([]);

        $this->assertArrayHasKey('data', $data);
    }

    /** @test */
    public function can_bing_work()
    {
        $imageGallery = $this->factory()->gallery('bing');

        $data = $imageGallery->get([]);

        $this->assertArrayHasKey('data', $data);
    }

    /** @test */
    public function can_unsplash_work()
    {
        $imageGallery = $this->factory()->gallery('unsplash');

        $data = $imageGallery->get([]);

        $this->assertArrayHasKey('data', $data);
    }

    /** @test */
    public function can_unsplash_search()
    {
        $imageGallery = $this->factory()->gallery('unsplash');

        $data = $imageGallery->get(['keywords' => 'mountain']);

        $this->assertArrayHasKey('data', $data);
    }

    /** @test */
    public function can_pixabay_work()
    {
        $imageGallery = $this->factory()->gallery('pixabay');

        $data = $imageGallery->get([]);

        $this->assertArrayHasKey('data', $data);
    }
}
