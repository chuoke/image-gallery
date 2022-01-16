<?php

namespace Chuoke\ImageGallery\Driver;

use Chuoke\ImageGallery\Params\PixabayListQueryParams;
use Illuminate\Http\Client\Response;

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

    /**
     * @var \Chuoke\ImageGallery\Params\PixabayListQueryParams
     */
    protected $params;

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
     * @param \Chuoke\ImageGallery\Params\PixabayListQueryParams|array $params
     * @return static
     */
    public function setParams($params)
    {
        $this->params = is_array($params) ? new PixabayListQueryParams($params) : $params;

        return $this;
    }

    public function getParams()
    {
        return $this->params ?? ($this->params = new PixabayListQueryParams([]));
    }

    /**
     * @param \Chuoke\ImageGallery\Params\PixabayListQueryParams|null $params
     * @return array
     */
    public function get($params = null)
    {
        if ($params) {
            $this->setParams($params);
        }

        $response = $this->http()->get(
            $this->determineQueryScope(),
            array_merge($this->getParams()->build() ?? [], ['key' => $this->apiKey])
        );

        $this->checkRequestFailed($response);

        $data = $response->json();

        return [
            'data' => $data['hits'],
            'has_more' => $data['total'] > ($this->getParams()->per_page * $this->getParams()->page),
        ];
    }

    public function determineQueryScope(): string
    {
        return $this->getParams()->video ? 'videos' : '';
    }

    public function isVideo(): bool
    {
        return $this->getParams()->video;
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
