<?php

namespace Chuoke\ImageGallery\Driver;

use Chuoke\ImageGallery\Contracts\ListQueryParams;
use Chuoke\ImageGallery\Params\UnsplashListQueryParams;
use Illuminate\Http\Client\Response;

/**
 * @see https://unsplash.com/documentation
 */
class Unsplash extends AbstractGallery
{
    protected $name = 'unsplash';

    protected $baseUrl = 'https://api.unsplash.com/';

    protected $accessKey;

    protected $configurable = [
        'access_key',
    ];

    public function setAccessKey($accessKey)
    {
        $this->accessKey = $accessKey;

        return $this;
    }

    public function withHeaders()
    {
        return [
            'Authorization' => 'Client-ID ' . $this->accessKey,
        ];
    }

    public function get(ListQueryParams $params)
    {
        if ($this->determineSearch($params)) {
            return $this->search($params);
        }

        $response = $this->http()->get('photos', $params->build());

        $this->checkRequestFailed($response);

        $data = $response->json();

        return [
            'images' => $data,
            'has_more' => count($data) >= $params->per_page,
        ];
    }

    public function search(ListQueryParams $params)
    {
        $response = $this->http()->get('search/photos', $params->build());

        $this->checkRequestFailed($response);

        $data = $response->json('results');

        return [
            'images' => $data,
            'has_more' => ($params->per_page * $params->page) > $response->json('total'),
        ];
    }

    protected function determineSearch(ListQueryParams $params)
    {
        if ($params instanceof UnsplashListQueryParams) {
            return false;
        }

        return $params->keywords
            || $params->color
            || $params->orientation
            || $params->content_filter;
    }

    protected function checkRequestFailed(Response $response)
    {
        if ($response->ok()) {
            return;
        }

        $this->throwRequestFailedException($response->json('errors')[0], $response->status());
    }
}
