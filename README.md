Lightweight implementation of enum value object in PHP.

## Installation
Use [Composer] to install the package:
```
composer require intraworlds/enum
```

## Usage
Extend `IW\Enum` and add arbitrary constants which becomes your enum keys.
```php
final class Hash extends Enum
{
  const MD5 = 'md5';
  const SHA1 = 'sha1';
}
```
Obtain instance of enum value by calling static function `<classname>::<key>()`.
```php
$md5 = Hash::MD5();
```
Main advantage of use this library is of cource type hinting. Therefore given instance is always valid in principle of DDD value object.
```php
function crack(Hash $hash) {
  echo 'cracking ... ' . $hash; // notice that enum is implementing __toString() method
}

crack(Hash::SHA1()); // cracking ... sha1
crack(Hash::SHA1);   // throws TypeError
```
The function is returning a singleton so you can compare it with `===`
```php
var_dump($md5 === MD5()); // true
var_dump($md5 === SHA1()); // false
```
Actually you must use `===` for strict comparison. With `==` [loose comparison] PHP compares only that objects are the same class.
```php
var_dump($md5 == MD5()); // true
var_dump($md5 == SHA1()); // true - DON'T use == comparison!
```
Access actual value with method `getValue()`
```php
var_dump($md5->getValue() === Hash::MD5); // true
```
Switch statements must be defined by values because of [loose comparison].
```php
switch ($hash->getValue()) {
  case Hash::MD5: ...
  case Hash::SHA1: ...
}
```
You can user method `search()` for obtaining instance of enum by a value.
```php
$contentType = ContentTypeEnum::search(apache_request_headers()['Content-Type']);
```

## Alternatives
- we took most of the inspiration from library [myclabs/php-enum]. It's nice implementation but it's missing singletons and it's not optimized for PHP7.
- PHP's [SplEnum] needs an extension and also does not support singletons.

## License
All contents of this package are licensed under the [MIT license].

[Composer]: https://getcomposer.org
[MIT license]: LICENSE
[loose comparison]: http://php.net/manual/en/types.comparisons.php#types.comparisions-loose
[myclabs/php-enum]: https://packagist.org/packages/myclabs/php-enum
[SplEnum]: https://secure.php.net/manual/en/class.splenum.php
