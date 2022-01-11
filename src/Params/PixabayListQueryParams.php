<?php

namespace Chuoke\ImageGallery\Params;

class PixabayListQueryParams extends ListQueryParams
{
    /**
     * Search terms.
     *
     * @var string
     */
    public string $keywords = '';

    /**
     * Retrieve individual images by ID.
     *
     * @var string
     */
    public string $id = '';

    /**
     * Filter results by image type.
     * Accepted values: "all", "photo", "illustration", "vector"
     * Default: "all"
     *
     * @var string
     */
    public $image_type = null;

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

    /**
     * The locale of the search you are performing.
     *
     * Accepted values: cs, da, de, en, es, fr, id, it, hu, nl, no, pl, pt, ro, sk, fi, sv, tr, vi, th, bg, ru, el, ja, ko, zh
     * Default: "en"
     * @see https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
     *
     * @var string
     */
    public $locale = '';

    /**
     * How the results should be ordered.
     * Accepted values: "popular", "latest"
     * Default: "popular"
     *
     * @var string
     */
    public string $order = '';

    /**
     * A flag indicating that only images suitable for all ages should be returned.
     * Accepted values: "true", "false"
     * Default: "false"
     *
     * @var boolean
     */
    public bool $safesearch = true;

    /**
     * Filter images by color properties.
     * A comma separated list of values may be used to select multiple properties.
     * Accepted values: "grayscale", "transparent", "red", "orange", "yellow", "green",
     * "turquoise", "blue", "lilac", "pink", "white", "gray", "black", "brown"
     * @var string
     */
    public $color = '';

    /**
     * Whether an image is wider than it is tall, or taller than it is wide.
     * Accepted values: "all", "horizontal", "vertical"
     * Default: "all"
     *
     * @var string
     */
    public $orientation = '';

    /**
     * Filter results by category.
     * Accepted values: backgrounds, fashion, nature, science, education, feelings,
     *                  health, people, religion, places, animals, industry, computer,
     *                  food, sports, transportation, travel, buildings, business, music
     *
     * @var string
     */
    public $category = '';

    /**
     * Minimum image width.
     *
     * @var integer
     */
    public $min_width = 0;

    /**
     * Minimum image height.
     *
     * @var integer
     */
    public $min_height = 0;

    /**
     * Select images that have received an Editor's Choice award.
     * Accepted values: "true", "false"
     *
     * @var boolean
     */
    public $editors_choice = false;

    /**
     * Is search video.
     *
     * @var boolean
     */
    public bool $video = false;

    /**
     * @inheritDoc
     */
    public function build()
    {
        return array_filter([
            'q' => $this->keywords,
            'page' => $this->page,
            'per_page' => $this->per_page,
            'lang' => $this->locale,
            'id' => $this->id,
            'image_type' => $this->image_type,
            'orientation' => $this->orientation,
            'category' => $this->category,
            'min_width' => $this->min_width,
            'min_height' => $this->min_height,
            'colors' => $this->color,
            'editors_choice' => $this->editors_choice,
            'safesearch' => $this->safesearch,
            'order' => $this->order,
        ]);
    }
}
