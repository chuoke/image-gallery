<?php

namespace Chuoke\ImageGallery\Driver;

use Chuoke\ImageGallery\Contracts\ListQueryParams;

class Bing extends AbstractGallery
{
    protected $name = 'bing';

    protected $baseUrl = 'https://bing.com/';

    public function getName()
    {
        return $this->name;
    }

    public function get(ListQueryParams $params)
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

    protected function buildListQueryParams(ListQueryParams $params)
    {
        // format=js&idx=0&n=1&nc=1578321325588&pid=hp
        return $params->build();
    }
}
