<?php

namespace Chuoke\ImageGallery\Driver;

use Chuoke\ImageGallery\Params\BingListQueryParams;

class Bing extends AbstractGallery
{
    protected $name = 'bing';

    protected $baseUrl = 'https://bing.com/';

    /**
     * @param  \Chuoke\ImageGallery\Params\BingListQueryParams  $params
     * @return array
     */
    public function get($params)
    {
        $response = $this->http()
            ->get(
                $this->listScope(),
                $this->buildListQueryParams($params)
            );

        $data = $response->json();

        $data['has_more'] = count($data['images']) >= $params->per_page;

        return $data;
    }

    protected function listScope()
    {
        return 'HPImageArchive.aspx';
    }

    protected function buildListQueryParams(BingListQueryParams $params)
    {
        // format=js&idx=0&n=1&nc=1578321325588&pid=hp
        return $params->build();
    }
}
