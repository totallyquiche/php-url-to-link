<?php
    declare(strict_types = 1);

    namespace TotallyQuiche\URLtoLink;

    require_once(__DIR__ . '/../vendor/autoload.php');

    use \PHPUnit\Framework\TestCase;

    /**
     * Tests Converter
     *
     * @group  Converter
     * @covers \TotallyQuiche\URLtoLink\Converter
     */
    class ConverterTest extends TestCase {
        /**
         * Provides test cases and expected results for parse method
         *
         * @return array
         */
        public function parseProvider() : array {
            return [
                'Empty string' => [
                    '',
                    []
                ],
                'Single URL' => [
                    'https://www.example.com:123/forum/questions/?tag=networking&order=newest#top',
                    [
                        'https://www.example.com:123/forum/questions/?tag=networking&order=newest#top'
                    ]
                ],
                'Multiple URLs' => [
                    'https://www.google.com http://www.google.com',
                    [
                        'https://www.google.com',
                        'http://www.google.com'
                    ]
                ],
                'Duplicate URLs' => [
                    'https://www.google.com https://www.google.com',
                    [
                        'https://www.google.com',
                    ]
                ],
                'URL with non-URL' => [
                    'https://www.google.com is a URL.',
                    [
                        'https://www.google.com',
                    ]
                ],
                'Period in URL' => [
                    'https://www.google.com. is a URL.',
                    [
                        'https://www.google.com.',
                    ]
                ],
                'String ends with URL and single period' => [
                    'My URL is https://www.google.com.',
                    [
                        'https://www.google.com'
                    ]
                ],
                'String ends with URL and multiple periods' => [
                    'My URL is https://www.google.com..',
                    [
                        'https://www.google.com.'
                    ]
                ]
            ];
        }

        /**
         * Tests parse method
         *
         * @dataProvider parseProvider
         * @param        string        $string
         * @param        array         $expected_result
         * @return       void
         */
        public function testParse(string $string, array $expected_result) : void {
            $converter = new Converter;
            $result = $converter->parse($string);

            $this->assertEquals($expected_result, $result);
        }

        /**
         * Provides test cases and expected results for convert method
         *
         * @return array
         */
        public function convertProvider() : array {
            return [
                'Empty string' => [
                    '',
                    ''
                ],
                'Single URL' => [
                    'https://www.example.com:123/forum/questions/?tag=networking&order=newest#top',
                    '<a href="https://www.example.com:123/forum/questions/?tag=networking&order=newest#top" target="_self">https://www.example.com:123/forum/questions/?tag=networking&order=newest#top</a>'
                ],
                'Multiple URLs' => [
                    'https://www.google.com http://www.google.com',
                    '<a href="https://www.google.com" target="_self">https://www.google.com</a> <a href="http://www.google.com" target="_self">http://www.google.com</a>'
                ],
                'Duplicate URLs' => [
                    'https://www.google.com https://www.google.com',
                    '<a href="https://www.google.com" target="_self">https://www.google.com</a> <a href="https://www.google.com" target="_self">https://www.google.com</a>'

                ],
                'URL with non-URL' => [
                    'https://www.google.com is a URL.',
                    '<a href="https://www.google.com" target="_self">https://www.google.com</a> is a URL.'
                ],
                'Period in URL' => [
                    'https://www.google.com. is a URL.',
                    '<a href="https://www.google.com." target="_self">https://www.google.com.</a> is a URL.'
                ],
                'String ends with URL and single period' => [
                    'My URL is https://www.google.com.',
                    'My URL is <a href="https://www.google.com" target="_self">https://www.google.com</a>.'
                ],
                'String ends with URL and multiple periods' => [
                    'My URL is https://www.google.com..',
                    'My URL is <a href="https://www.google.com." target="_self">https://www.google.com.</a>.'
                ]
            ];
        }

        /**
         * Tests convert method
         *
         * @dataProvider convertProvider
         * @param        string          $string
         * @param        string          $expected_result
         * @return       void
         */
        public function testConvert(string $string, string $expected_result) : void {
            $converter = new Converter;
            $result = $converter->convert($string);

            $this->assertEquals($expected_result, $result);
        }
    }