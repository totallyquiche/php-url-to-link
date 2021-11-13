<?php declare(strict_types = 1);

namespace TotallyQuiche\URLtoLink;

class Converter {
    /**
     * @const string
     */
    private const SCHEME_REGEX = '(?:(?:\b)(?:http|https)\:\/\/)';

    /**
     * @const string
     */
    const HOST_REGEX = '(?:[a-zA-Z0-9\!\$\&\'\(\)\*\+\,\;\=\%\.\-\_]*)';

    /**
     * @const string
     */
    const PORT_REGEX = '(?:(?:\:[0-9]+))';

    /**
     * @const string
     */
    const PATH_REGEX = '(?:(?:\/[a-zA-Z0-9\!\$\&\'\(\)\*\+\,\;\=\%\:\@\/\-\_\.]*)?)';

    /**
     * @const string
     */
    const QUERY_REGEX = '(?:\?[a-zA-Z0-9\!\$\&\'\(\)\*\+\,\;\=\%\:\@\/\-\_\.]*)';

    /**
     * @const string
     */
    const FRAGMENT_REGEX = '(?:\#[a-zA-Z0-9\!\$\&\'\(\)\*\+\,\;\=\%\:\@\/\-\_\.]*)';

    /**
     * @const string
     */
    const URL_REGEX = '/(?<URL>' .
        self::SCHEME_REGEX .
        self::HOST_REGEX .
        self::PORT_REGEX .
        '?' .
        self::PATH_REGEX .
        '?' .
        self::QUERY_REGEX .
        '?' .
        self::FRAGMENT_REGEX .
        '?)/';

    /**
     * Accepts a string and returns an array of unique URLs found therein
     *
     * @param string $string
     *
     * @return array
     */
    public static function parse(string $string) : array
    {
        preg_match_all(
            self::URL_REGEX,
            $string,
            $matches,
            PREG_SET_ORDER
        );

        $urls = [];

        foreach ($matches as $match) {
            $urls[] = $match['URL'];
        }

        return array_unique($urls);
    }

    /**
     * Accepts a string, converts URLs found therein into HTML anchor tags, and
     * returns the resulting string.
     *
     * @param string $string
     * @param string $target
     *
     * @return string
     */
    public static function convert(string $string, string $target = '_SELF') : string
    {
        $urls = self::parse($string);

        // Sort URLs so we don't make changes to longer URLs that contain short URLs
        usort($urls, fn($a, $b) => strlen($a) - strlen($b));

        foreach ($urls as $url) {
            $string = str_replace(
                $url,
                '<a href="' . $url . '" target="' . $target . '">' . $url . '</a>',
                $string
            );
        }

        return $string;
    }
}