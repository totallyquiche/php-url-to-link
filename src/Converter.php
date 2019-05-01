<?php
    declare(strict_types = 1);

    namespace TotallyQuiche\URLtoLink;

    class Converter {
        const SCHEME_REGEX = '(?:(?:\b)(?:http|https)\:\/\/)';
        const HOST_REGEX = '(?:[a-zA-Z0-9\!\$\&\'\(\)\*\+\,\;\=\%\.\-\_]*)';
        const PORT_REGEX = '(?:(?:\:[0-9]+))';
        const PATH_REGEX = '(?:(?:\/[a-zA-Z0-9\!\$\&\'\(\)\*\+\,\;\=\%\:\@\/\-\_\.]*)?)';
        const QUERY_REGEX = '(?:\?[a-zA-Z0-9\!\$\&\'\(\)\*\+\,\;\=\%\:\@\/\-\_\.]*)';
        const FRAGMENT_REGEX = '(?:\#[a-zA-Z0-9\!\$\&\'\(\)\*\+\,\;\=\%\:\@\/\-\_\.]*)';

        private $url_regex;

        /**
         * Initializes this object
         */
        public function __construct() {
            $this->url_regex = '/(?<URL>' . self::SCHEME_REGEX . self::HOST_REGEX . self::PORT_REGEX . '?' . self::PATH_REGEX . '?' . self::QUERY_REGEX . '?' . self::FRAGMENT_REGEX . '?)/';
        }

        /**
         * Accepts a string and returns an array of unique URLs found therein
         *
         * @param  string $string
         * @return array
         */
        public function parse(string $string) : array {
            preg_match_all($this->url_regex,
                           $string,
                           $matches,
                           PREG_SET_ORDER);

            $urls = [];

            foreach ($matches as $match) {
                $urls[] = $match['URL'];
            }

            return array_unique($urls);
        }

        /**
         * Accepts a string, converts URLs found therein into HTML anchor tags, and returns the resulting string
         *
         * @param  string $string
         * @param  string $target
         * @return string
         */
        public function convert(string $string, string $target = '_SELF') : string {
            $urls = $this->parse($string);

            // Sort URLs so we don't make changes to longer URLs that contain short URLs
            usort($urls, function($first, $second) {
                return strlen($first) - strlen($second);
            });

            foreach ($urls as $url) {
                $string = str_replace($url,
                                      '<a href="' . $url . '" target="' . $target . '">' . $url . '</a>',
                                      $string);
            }

            return $string;
        }
    }