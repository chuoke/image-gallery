<?php

namespace Chuoke\ImageGallery\Driver;

use Illuminate\Http\Client\Response;
use Chuoke\ImageGallery\Params\PixabayListQueryParams;

/**
 * @see https://pixabay.com/api/docs
 */
class Pixabay extends AbstractGallery
{
    protected $name = 'pixabay';

    protected $baseUrl = 'https://pixabay.com/api/';

    protected $apiKey;

    protected $configurable = [
        'api_key',
    ];

    public function setApiKey(string $apiKey): static
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function withHeaders(): array
    {
        return [];
    }

    /**
     * @param \Chuoke\ImageGallery\Params\PixabayListQueryParams $params
     * @return array
     */
    public function get($params)
    {
        $response = $this->http()->get(
            $this->determineQueryScope($params),
            array_merge($params->build(), ['key' => $this->apiKey])
        );

        $this->checkRequestFailed($response);

        $data = $response->json();

        return [
            'images' => $data['hits'],
            'has_more' => $data['total'] > ($params->per_page * $params->page),
        ];
    }

    public function determineQueryScope(PixabayListQueryParams $params): string
    {
        return $params->video ? 'videos' : '';
    }

    /**
     * @param  Response  $response
     * @return void
     * @throws \Exception
     */
    protected function checkRequestFailed(Response $response): void
    {
        if ($response->ok()) {
            return;
        }

        $this->throwRequestFailedException($response->json('error') ?: $response->body(), $response->status());
    }
}
