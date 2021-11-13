# php-url-to-link
Allows for parsing simple URLs from a string and/or converting them into HTML anchor tags.

## Parse Example

```php
$string = 'Get Lorem ipsum from https://www.lipsum.com/ or Cat Lipsum from http://www.catipsum.com';

$urls = Converter::parse($string);

var_dump($urls);
```

Output:
```html
array(2) {
  [0]=>
  string(23) "https://www.lipsum.com/"
  [1]=>
  string(23) "http://www.catipsum.com"
}
```

## Convert Example

```php
$string = 'Get Lorem ipsum from https://www.lipsum.com/ or Cat Lipsum from http://www.catipsum.com';

$urls = Converter::parse($string);

foreach ($urls as $url) {
    $string = str_replace(
        $url,
        Converter::convert($url),
        $string
    );
}

echo $string;
```

Output:
```html
Get Lorem ipsum from <a href="https://www.lipsum.com/" target="_SELF">https://www.lipsum.com/</a> or Cat Lipsum from <a href="http://www.catipsum.com" target="_SELF">http://www.catipsum.com</a>
```

### Convert Example with Target

```php
$string = 'Get Lorem ipsum from https://www.lipsum.com/ or Cat Lipsum from http://www.catipsum.com';

$urls = Converter::parse($string);

foreach ($urls as $url) {
    $string = str_replace(
        $url,
        Converter::convert($url, '_BLANK'),
        $string
    );
}

echo $string;
```

Output:
```html
Get Lorem ipsum from <a href="https://www.lipsum.com/" target="_BLANK">https://www.lipsum.com/</a> or Cat Lipsum from <a href="http://www.catipsum.com" target="_BLANK">http://www.catipsum.com</a>
```