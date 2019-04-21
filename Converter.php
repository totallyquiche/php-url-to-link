<?php
    declare(strict_types = 1);

    namespace TotallyQuiche\URItoLink;

    class Converter {
        const URI_REGEX = '/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';

        /**
         * Accepts a string and returns an array of URIs found therein
         *
         * @param string $string
         * @return array
         */
        public static function parse(string $string) : array {
            preg_match_all(self::URI_REGEX, $string, $matches, PREG_PATTERN_ORDER);

            return $matches[0];
        }

        /**
         * Accepts a string and replaces URIs found therein with HTML anchor tags
         *
         * @param string $string
         * @return string
         */
        public static function replace(string $string, string $target = '_SELF') : string {
            $replacement = '<a href="${0}" target="' . $target . '">${0}</a>';

            return preg_replace(self::URI_REGEX, $replacement, $string);
        }
    }