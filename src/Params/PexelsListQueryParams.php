<?php

namespace Chuoke\ImageGallery\Params;

class PexelsListQueryParams extends ListQueryParams
{
    /**
     * Search terms.
     *
     * @var string
     */
    public $keywords = '';

    /**
     * Minimum photo size.
     * The current supported sizes are:
     *        large(24MP), medium(12MP) or small(4MP).
     *
     * @var string
     */
    public $size;

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
     * Desired photo color.
     * Supported colors:
     *           red, orange, yellow, green, turquoise, blue, violet,
     *           pink, brown, black, gray, white
     *           or any hexidecimal color code (eg. #ffffff).
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

    /**
     * The locale of the search you are performing.
     * The current supported locales are:
     *          'en-US' 'pt-BR' 'es-ES' 'ca-ES' 'de-DE' 'it-IT' 'fr-FR'
     *          'sv-SE' 'id-ID' 'pl-PL' 'ja-JP' 'zh-TW' 'zh-CN' 'ko-KR'
     *          'th-TH' 'nl-NL' 'hu-HU' 'vi-VN' 'cs-CZ' 'da-DK' 'fi-FI'
     *          'uk-UA' 'el-GR' 'ro-RO' 'nb-NO' 'sk-SK' 'tr-TR' 'ru-RU'
     *
     * @var string
     */
    public $locale = '';

    /**
     * @inheritDoc
     */
    public function build()
    {
        return array_filter([
            'query' => $this->keywords,
            'page' => $this->page,
            'perPage' => $this->per_page,
            'locale' => $this->locale,
            'color' => $this->color,
            'orientation' => $this->orientation,
        ]);
    }
}
