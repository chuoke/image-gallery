<?php

namespace Chuoke\ImageGallery\Driver;

use Chuoke\ImageGallery\Params\BingListQueryParams;

class Bing extends AbstractGallery
{
    protected $name = 'bing';

    protected $baseUrl = 'https://bing.com/';

    /**
     * @var \Chuoke\ImageGallery\Params\BingListQueryParams
     */
    protected $params;

    /**
     * @param \Chuoke\ImageGallery\Params\BingListQueryParams|array $params
     * @return static
     */
    public function setParams($params)
    {
        $this->params = is_array($params) ? new BingListQueryParams($params) : $params;

        return $this;
    }

    public function getParams()
    {
        return $this->params ?? ($this->params = new BingListQueryParams([]));
    }

    /**
     * @param  \Chuoke\ImageGallery\Params\BingListQueryParams|null  $params
     * @return array
     */
    public function get($params = null)
    {
        if ($params) {
            $this->setParams($params);
        }

        $response = $this->http()->get('HPImageArchive.aspx', $this->buildListQueryParams());

        $data = $response->json();

        return [
            'data' => $data['images'] ?? [],
            'has_more' => count($data['images'] ?? []) >= $this->getParams()->per_page,
        ];
    }

    protected function buildListQueryParams()
    {
        // format=js&idx=0&n=8
        return $this->getParams()->build();
    }
}
