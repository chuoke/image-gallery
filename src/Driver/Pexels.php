<?php

namespace Chuoke\ImageGallery\Driver;

use Chuoke\ImageGallery\Params\PexelsListQueryParams;
use Illuminate\Http\Client\Response;

/**
 * @see https://www.pexels.com/api/documentation/
 */
class Pexels extends AbstractGallery
{
    protected $name = 'pexels';

    protected $baseUrl = 'https://api.pexels.com/v1/';

    protected $apiKey;

    /**
     * @var array
     */
    protected $configurable = [
        'api_key',
    ];

    /**
     * @var \Chuoke\ImageGallery\Params\PexelsListQueryParams
     */
    protected $params;

    /**
     * @param  string  $apiKey
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function withHeaders()
    {
        return [
            'Authorization' => $this->apiKey,
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36',
        ];
    }

    /**
     * @param \Chuoke\ImageGallery\Params\PexelsListQueryParams|array $params
     * @return static
     */
    public function setParams($params)
    {
        $this->params = is_array($params) ? new PexelsListQueryParams($params) : $params;

        return $this;
    }

    public function getParams()
    {
        return $this->params ?? ($this->params = new PexelsListQueryParams([]));
    }

    /**
     * @param \Chuoke\ImageGallery\Params\PexelsListQueryParams|null $params
     * @return array
     */
    public function get($params = null)
    {
        if ($params) {
            $this->setParams($params);
        }

        if ($this->getParams()->video) {
            return $this->getVideos();
        }

        return $this->getImages();
    }

    public function getImages()
    {
        $response = $this->http()->get(
            $this->determineImageQueryScope(),
            $this->getParams()->build()
        );

        $this->checkRequestFailed($response);

        $data = $response->json();

        return [
            'data' => $data['photos'],
            'has_more' => $data['total_results'] > ($data['page'] * $data['per_page']),
        ];
    }

    public function getVideos()
    {
        $response = $this->http()->get(
            $this->determineVideoQueryScope(),
            $this->getParams()->build()
        );

        $this->checkRequestFailed($response);

        $data = $response->json();

        return [
            'data' => $data['videos'],
            'has_more' => $data['total_results'] > ($data['page'] * $data['per_page']),
        ];
    }

    public function determineImageQueryScope(): string
    {
        return $this->getParams()->keywords || $this->getParams()->orientation || $this->getParams()->color
            ? 'search'
            : 'curated';
    }

    public function determineVideoQueryScope(): string
    {
        return $this->getParams()->keywords || $this->getParams()->orientation || $this->getParams()->color
            ? 'videos/search'
            : 'videos/popular';
    }

    public function isVideo(): bool
    {
        return $this->getParams()->video;
    }

    protected function checkRequestFailed(Response $response)
    {
        if ($response->ok()) {
            return;
        }

        $this->throwRequestFailedException($response->json('error'), $response->status());
    }
}
