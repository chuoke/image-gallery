<?php

namespace Chuoke\ImageGallery\Driver;

use Chuoke\ImageGallery\Params\UnsplashListQueryParams;
use Illuminate\Http\Client\Response;

/**
 * @see https://unsplash.com/documentation
 */
class Unsplash extends AbstractGallery
{
    protected $name = 'unsplash';

    protected $baseUrl = 'https://api.unsplash.com/';

    protected $apiKey;

    protected $configurable = [
        'api_key',
    ];

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function withHeaders()
    {
        return [
            'Authorization' => 'Client-ID ' . $this->apiKey,
        ];
    }

    /**
     * @param \Chuoke\ImageGallery\Params\UnsplashListQueryParams|array $params
     * @return static
     */
    public function setParams($params)
    {
        $this->params = is_array($params) ? new UnsplashListQueryParams($params) : $params;

        return $this;
    }

    public function getParams()
    {
        return $this->params ?? ($this->params = new UnsplashListQueryParams([]));
    }

    /**
     * @param \Chuoke\ImageGallery\Params\UnsplashListQueryParams|null $params
     * @return array
     */
    public function get($params = null)
    {
        if ($params) {
            $this->setParams($params);
        }

        if ($this->determineSearch()) {
            return $this->search();
        }

        $response = $this->http()->get('photos', $this->getParams()->build());

        $this->checkRequestFailed($response);

        $data = $response->json();

        return [
            'data' => $data ?: [],
            'has_more' => count($data ?: []) >= $params->per_page,
        ];
    }

    /**
     * @param  \Chuoke\ImageGallery\Params\UnsplashListQueryParams  $params
     * @return array
     */
    public function search($params = null)
    {
        if ($params) {
            $this->setParams($params);
        }

        $response = $this->http()->get('search/photos', array_filter($this->getParams()->build()));

        $this->checkRequestFailed($response);

        $data = $response->json('results');

        return [
            'data' => $data,
            'has_more' => ($this->getParams()->per_page * $this->getParams()->page) < $response->json('total'),
        ];
    }

    protected function determineSearch()
    {
        return $this->getParams()->keywords
            || $this->getParams()->color
            || $this->getParams()->orientation
            || $this->getParams()->content_filter;
    }

    protected function checkRequestFailed(Response $response)
    {
        if ($response->ok()) {
            return;
        }

        $this->throwRequestFailedException($response->json('errors')[0], $response->status());
    }
}
