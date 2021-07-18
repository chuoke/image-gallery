<?php

namespace Chuoke\ImageGallery\Driver;

use Chuoke\ImageGallery\Contracts\ListQueryParams;
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

    public function get(ListQueryParams $params)
    {
        $response = $this->http()->get(
            $this->determineListQueryScope($params),
            $params->build()
        );

        $this->checkRequestFailed($response);

        $data = $response->json();

        return [
            'images' => $data['photos'],
            'has_more' => $data['total_results'] > ($data['page'] * $data['per_page']),
        ];
    }

    public function determineListQueryScope(PexelsListQueryParams $params)
    {
        return $params->keywords || $params->orientation || $params->color
            ? 'search' : 'curated';
    }

    protected function checkRequestFailed(Response $response)
    {
        if ($response->ok()) {
            return;
        }

        $this->throwRequestFailedException($response->json('error'), $response->status());
    }
}
