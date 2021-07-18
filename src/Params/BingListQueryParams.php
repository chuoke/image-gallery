<?php

namespace Chuoke\ImageGallery\Params;

class BingListQueryParams extends ListQueryParams
{
    /**
     * Page number to retrieve. (Optional; default: 1)
     *
     * @var int
     */
    public $page = 1;

    /**
     * Number of items per page. (Optional; default: 10)
     *
     * @var int
     */
    public $per_page = 10;

    public function build()
    {
        return [
            'format' => 'js',
            'idx' => ($this->page - 1) * $this->per_page,
            'n' => $this->per_page,
            'nc' => microtime(true) * 1000,
            'pid' => 'hp',
        ];
    }
}
