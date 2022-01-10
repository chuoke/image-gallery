<?php

namespace Chuoke\ImageGallery\Params;

class BingListQueryParams extends ListQueryParams
{
    /**
     * Page number to retrieve. (Optional; default: -1)
     * Map to `idx`, which says which day of data to get
     * -1 is tomorrow、 0 today 、 1 yesterday ...
     * @var int
     */
    public $page = -1;

    /**
     * Number of items per page. (Optional; default: 8, max: 8)
     *
     * @var int
     */
    public $per_page = 8;

    /**
     * The region parameter,
     * the default value is zh-CN,
     * you can also use en-US, ja-JP, en-AU, en-UK, de-DE, en-NZ, en-CA.
     *
     * @var string
     */
    public $locale = '';

    public function build()
    {
        // The maximum is 8
        $this->per_page = min($this->per_page, 8);

        return [
            'format' => 'js',
            'idx' => $this->page,
            'n' => $this->per_page,
            'mkt' => $this->locale,
        ];
    }
}
