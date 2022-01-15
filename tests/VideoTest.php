<?php

namespace Chuoke\ImageGallery\Tests;

use PHPUnit\Framework\TestCase;


class VideoTest extends TestCase
{
    use BaseTest;

    /** @test */
    public function can_pexels_work()
    {
        $imageGallery = $this->factory()->gallery('pexels');

        $data = $imageGallery->get(['video' => true]);

        $this->assertArrayHasKey('data', $data);
    }

    /** @test */
    public function can_pixabay_work()
    {
        $imageGallery = $this->factory()->gallery('pixabay');

        $data = $imageGallery->get(['video' => true]);

        $this->assertArrayHasKey('data', $data);
    }
}
