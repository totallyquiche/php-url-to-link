<?php
    declare(strict_types = 1);

    use \PHPUnit\Framework\TestCase;

    /**
     * Tests Converter
     *
     * @covers Converter
     */
    class ConverterTest extends TestCase {
        /**
         * Data Provider for Converter::parse
         *
         * @return array
         */
        public function parseProvider() : array {
            return [
                ['', []],
                ['This is a string with no URI.', []],
                ['http://www.google.com', ['http://www.google.com']],
                ['http://www.google.comhttp://www.google.com', ['http://www.google.com', 'http://www.google.com']],
                ['http://www.google.com http://www.google.com', ['http://www.google.com', 'http://www.google.com']],
                ['http://www.google.comahttp://www.google.com', ['http://www.google.com', 'http://www.google.com']],
                ['http://www.google.com0http://www.google.com', ['http://www.google.com', 'http://www.google.com']],
                ['http://www.google.com&http://www.google.com', ['http://www.google.com', 'http://www.google.com']]
            ];
        }

        /**
         * Test for Converter::parse
         *
         * @dataProvider parseProvider
         * @covers Converter::parse
         *
         * @param string $string
         * @param array $expected
         */
        public function testParse(string $string, array $expected) {
            $results = \TotallyQuiche\URItoLink\Converter::parse($string);

            $this->assertIsArray($results);
            $this->assertEquals($expected, $results);
        }

        /**
         * Data Provider for Converter::replace
         *
         * @return array
         */
        public function replaceProvider() : array {
            return [
                ['', '', ''],
                ['This is a string with no URI.', '', 'This is a string with no URI.'],
                ['http://www.google.com', '', '<a href="http://www.google.com" target="">http://www.google.com</a>'],
                ['http://www.google.comhttp://www.google.com', '', '<a href="http://www.google.com" target="">http://www.google.com</a><a href="http://www.google.com" target="">http://www.google.com</a>'],
                ['http://www.google.com http://www.google.com', '', '<a href="http://www.google.com" target="">http://www.google.com</a> <a href="http://www.google.com" target="">http://www.google.com</a>'],
                ['http://www.google.comahttp://www.google.com', '', '<a href="http://www.google.com" target="">http://www.google.com</a>a<a href="http://www.google.com" target="">http://www.google.com</a>'],
                ['http://www.google.com0http://www.google.com', '', '<a href="http://www.google.com" target="">http://www.google.com</a>0<a href="http://www.google.com" target="">http://www.google.com</a>'],
                ['http://www.google.com&http://www.google.com', '', '<a href="http://www.google.com" target="">http://www.google.com</a>&<a href="http://www.google.com" target="">http://www.google.com</a>'],
                ['', '_SELF', ''],
                ['This is a string with no URI.', '_SELF', 'This is a string with no URI.'],
                ['http://www.google.com', '_SELF', '<a href="http://www.google.com" target="_SELF">http://www.google.com</a>'],
                ['http://www.google.comhttp://www.google.com', '_SELF', '<a href="http://www.google.com" target="_SELF">http://www.google.com</a><a href="http://www.google.com" target="_SELF">http://www.google.com</a>'],
                ['http://www.google.com http://www.google.com', '_SELF', '<a href="http://www.google.com" target="_SELF">http://www.google.com</a> <a href="http://www.google.com" target="_SELF">http://www.google.com</a>'],
                ['http://www.google.comahttp://www.google.com', '_SELF', '<a href="http://www.google.com" target="_SELF">http://www.google.com</a>a<a href="http://www.google.com" target="_SELF">http://www.google.com</a>'],
                ['http://www.google.com0http://www.google.com', '_SELF', '<a href="http://www.google.com" target="_SELF">http://www.google.com</a>0<a href="http://www.google.com" target="_SELF">http://www.google.com</a>'],
                ['http://www.google.com&http://www.google.com', '_SELF', '<a href="http://www.google.com" target="_SELF">http://www.google.com</a>&<a href="http://www.google.com" target="_SELF">http://www.google.com</a>'],
                ['', null, ''],
                ['This is a string with no URI.', null, 'This is a string with no URI.'],
                ['http://www.google.com', null, '<a href="http://www.google.com" target="_SELF">http://www.google.com</a>'],
                ['http://www.google.comhttp://www.google.com', null, '<a href="http://www.google.com" target="_SELF">http://www.google.com</a><a href="http://www.google.com" target="_SELF">http://www.google.com</a>'],
                ['http://www.google.com http://www.google.com', null, '<a href="http://www.google.com" target="_SELF">http://www.google.com</a> <a href="http://www.google.com" target="_SELF">http://www.google.com</a>'],
                ['http://www.google.comahttp://www.google.com', null, '<a href="http://www.google.com" target="_SELF">http://www.google.com</a>a<a href="http://www.google.com" target="_SELF">http://www.google.com</a>'],
                ['http://www.google.com0http://www.google.com', null, '<a href="http://www.google.com" target="_SELF">http://www.google.com</a>0<a href="http://www.google.com" target="_SELF">http://www.google.com</a>'],
                ['http://www.google.com&http://www.google.com', null, '<a href="http://www.google.com" target="_SELF">http://www.google.com</a>&<a href="http://www.google.com" target="_SELF">http://www.google.com</a>'],
            ];
        }

        /**
         * Test for Converter::replace
         *
         * @dataProvider replaceProvider
         * @covers Converter::replace
         *
         * @param string $string
         * @param mixed $target
         * @param string $expected
         */
        public function testReplace(string $string, $target, string $expected) {
            $results = is_null($target) ? $results = \TotallyQuiche\URItoLink\Converter::replace($string)
                                        : $results = \TotallyQuiche\URItoLink\Converter::replace($string, $target);

            $this->assertIsString($results);
            $this->assertEquals($expected, $results);
        }
    }