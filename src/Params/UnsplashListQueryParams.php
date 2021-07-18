<?php

namespace Chuoke\ImageGallery\Params;

use Chuoke\ImageGallery\Params\ListQueryParams;

class UnsplashListQueryParams extends ListQueryParams
{
    /**
     * Search terms.
     *
     * @var string
     */
    public $keywords = '';

    /**
     * Page number to retrieve. (Optional; default: 1)
     *
     * @var integer
     */
    public $page = 1;

    /**
     * Number of items per page. (Optional; default: 10)
     *
     * @var integer
     */
    public $per_page = 10;

    /**
     * How to sort the photos. (Optional; default: relevant).
     * Valid values are latest and relevant.
     *
     * @var string
     */
    public $order_by = '';

    /**
     * Limit results by content safety. (Optional; default: low).
     * Valid values are low and high.
     *
     * @var string
     */
    public $content_filter = '';

    /**
     * Filter results by color. Optional.
     * Valid values are:
     *       black_and_white, black, white, yellow, orange,
     *       red, purple, magenta, green, teal, and blue.
     *
     * @var string
     */
    public $color = '';

    /**
     * Filter by photo orientation. Optional. (Valid values: landscape, portrait, squarish)
     *
     * @var string
     */
    public $orientation = '';

    public function build()
    {
        return [
            'query' => $this->keywords,
            'page' => $this->page,
            'per_page' => $this->per_page,
            'order_by' => $this->order_by,
            'content_filter' => $this->content_filter,
            'color' => $this->color,
            'orientation' => $this->orientation,
        ];
    }
}
