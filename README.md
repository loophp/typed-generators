[![Latest Stable Version][latest stable version]][1]
 [![GitHub stars][github stars]][1]
 [![Total Downloads][total downloads]][1]
 [![GitHub Workflow Status][github workflow status]][2]
 [![Scrutinizer code quality][code quality]][3]
 [![Type Coverage][type coverage]][4]
 [![Code Coverage][code coverage]][3]
 [![Mutation testing badge][mutation badge image]][mutation badge link]
 [![License][license]][1]
 [![Donate!][donate github]][5]

# PHP Typed Generators

## Description

Generate random typed values and in any shape.

Useful for writing your tests, there's no need to write static set of typed
values, you can now generate them using this tool.

Each generated random values or shape is fully typed and can safely be used by
existing static analysis tools such as PHPStan or PSalm.

## Installation

```composer require loophp/typed-generators```

## Usage

This library has a single entry point class factory. By using a single factory
class, the user is able to quickly instantiate objects and use auto-completion.

Find the complete API directly in the [`TG` class][tg class].

### Quick API overview

```php
<?php

declare(strict_types=1);

namespace Snippet;

use loophp\TypedGenerators\TG;

include __DIR__ . '/vendor/autoload.php';

$arrays    = TG::array(TG::string(), TG::string());
$arrayKeys = TG::arrayKey();
$booleans  = TG::bool();
$closures  = TG::closure();
$compounds = TG::compound(TG::bool(), TG::int());
$customs   = TG::custom(TG::string(), static fn (): string => 'bar');
$datetimes = TG::datetime();
$faker     = TG::faker(TG::string(), static fn (Faker\Generator $faker): string => $faker->city());
$floats    = TG::float();
$integers  = TG::int();
$iterators = TG::iterator(TG::bool(), TG::string());
$lists     = TG::list(TG::string());
$negatives = TG::negativeInt();
$nulls     = TG::null();
$nullables = TG::nullable(TG::string());
$numerics  = TG::numeric();
$objects   = TG::object();
$positives = TG::positiveInt();
$statics   = TG::static(TG::string(), 'foo');
$strings   = TG::string();
$uniqids   = TG::uniqid();
```

### Generate list of values

<details>

```php
<?php

declare(strict_types=1);

namespace Snippet;

use loophp\TypedGenerators\TG;

include __DIR__ . '/vendor/autoload.php';

$strings = TG::string();       // Generate strings

foreach ($strings as $string) {
    var_dump($string);         // Random string generated
}

echo $strings();               // Print one random string
```

</details>


### Generate KeyValue pairs

<details>

```php
<?php

declare(strict_types=1);

namespace Snippet;

use loophp\TypedGenerators\TG;

include __DIR__ . '/vendor/autoload.php';

$iteratorStringBool = TG::iterator(
    TG::string(),       // Keys: Generate strings for keys
    TG::bool()          // Values: Generate booleans for values
);

foreach ($iteratorStringBool() as $key => $value) {
    var_dump($key, $value);   // Random string for key, random boolean for value.
}
```

</details>

### Integration with Faker

<details>

```php
<?php

declare(strict_types=1);

namespace Snippet;

use Faker\Generator;
use loophp\TypedGenerators\TG;

include __DIR__ . '/vendor/autoload.php';

$fakerType = TG::faker(
    TG::string(),
    fn (Generator $faker): string => $faker->city()
);

$iterator = TG::iterator(
    TG::string(4), // Keys: A random string of length 4
    $fakerType     // Values: A random city name
);

foreach ($iterator() as $key => $value) {
    var_dump($key, $value);
}
```

</details>

### Use random compound values

Compound values are values that can be either of type `A` or type `B`.

<details>

```php
<?php

declare(strict_types=1);

namespace Snippet;

use Faker\Generator;
use loophp\TypedGenerators\TG;

include __DIR__ . '/vendor/autoload.php';

$fakerType = TG::faker(
    TG::string(),
    fn (Generator $faker): string => $faker->firstName()
);

$iterator = TG::iterator(
    TG::bool(),    // Keys: A random boolean
    TG::compound(  // Values: A random compound value which can be
        $fakerType,// either a firstname
        TG::int()  // either an integer.
    )
);

foreach ($iterator() as $key => $value) {
    var_dump($key, $value);
}
```

</details>

### Generate a complex typed array shape

<details>

```php
<?php

declare(strict_types=1);

namespace Snippet;

use Faker\Generator;
use loophp\TypedGenerators\TG;

include __DIR__ . '/vendor/autoload.php';

$iterator = TG::array(TG::static(TG::string(), 'id'), TG::int(6))
    ->add(
        TG::static(TG::string(), 'uuid'),
        TG::uniqid()
    )
    ->add(
        TG::static(TG::string(), 'firstName'),
        TG::faker(
            TG::string(),
            static fn (Generator $faker): string => $faker->firstName()
        )
    )
    ->add(
        TG::static(TG::string(), 'country'),
        TG::faker(
            TG::string(),
            static fn (Generator $faker): string => $faker->country()
        )
    )
    ->add(
        TG::static(TG::string(), 'isCitizen'),
        TG::bool()
    )
    ->add(
        TG::static(TG::string(), 'hometowm'),
        TG::faker(
            TG::string(),
            static fn (Generator $faker): string => $faker->city()
        )
    )
    ->add(
        TG::static(TG::string(), 'lastSeen'),
        TG::datetime()
    );

foreach ($iterator as $k => $v) {
    // \PHPStan\dumpType($v);
    /** @psalm-trace $v */
    print_r($v);
}
```

</details>

This example will produce such arrays:

<details>

```
Array
(
    [id] => 545327499
    [uuid] => 629f7198091ee
    [firstName] => Sandra
    [country] => Sardinia
    [isCitizen] => 1
    [hometowm] => Ecaussinnes
    [lastSeen] => DateTimeImmutable Object
        (
            [date] => 2009-06-02 07:40:37.000000
            [timezone_type] => 3
            [timezone] => UTC
        )
)
Array
(
    [id] => 623241523
    [uuid] => 629f719809290
    [firstName] => Paolo
    [country] => Sicily
    [isCitizen] =>
    [hometowm] => Quaregnon
    [lastSeen] => DateTimeImmutable Object
        (
            [date] => 1989-11-11 16:22:02.000000
            [timezone_type] => 3
            [timezone] => UTC
        )
)
```

</details>

Analyzing the `$iterator` variable with PSalm and PHPStan will give:

<details>

```shell
$ ./vendor/bin/phpstan analyse --level=9 test.php
```

```
 1/1 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100%

 ------ --------------------------------------------------------
  Line   test.php
 ------ --------------------------------------------------------
  45     Dumped type: array<string, bool|DateTimeInterface|int|string>
 ------ --------------------------------------------------------
```

</details>

With PSalm:

<details>

```shell
$ ./vendor/bin/psalm --show-info=true --no-cache test.php
```

```
Target PHP version: 7.4 (inferred from composer.json)
Scanning files...
Analyzing files...

I

INFO: Trace - test.php:46:5 - $v: array<string, DateTimeInterface|bool|int|string> (see https://psalm.dev/224)
```

</details>

## Code quality, tests, benchmarks

Every time changes are introduced into the library, [Github][2] runs the
tests.

The library has tests written with [PHPUnit][35].
Feel free to check them out in the `tests` directory.

Before each commit, some inspections are executed with [GrumPHP][36]; run
`composer grumphp` to check manually.

The quality of the tests is tested with [Infection][37] a PHP Mutation testing
framework - run `composer infection` to try it.

Static analyzers are also controlling the code. [PHPStan][38] and
[PSalm][39] are enabled to their maximum level.

## Contributing

Feel free to contribute by sending pull requests. We are a
usually very responsive team and we will help you going
through your pull request from the beginning to the end.

For some reasons, if you can't contribute to the code and
willing to help, sponsoring is a good, sound and safe way
to show us some gratitude for the hours we invested in this
package.

Sponsor me on [Github][5] and/or any of [the contributors][6].

## Changelog

See [CHANGELOG.md][43] for a changelog based on [git commits][44].

For more detailed changelogs, please check [the release changelogs][45].

[latest stable version]: https://img.shields.io/packagist/v/loophp/typed-generators.svg?style=flat-square
[github stars]: https://img.shields.io/github/stars/loophp/typed-generators.svg?style=flat-square
[total downloads]: https://img.shields.io/packagist/dt/loophp/typed-generators.svg?style=flat-square
[github workflow status]: https://img.shields.io/github/workflow/status/loophp/typed-generators/Unit%20tests?style=flat-square
[code quality]: https://img.shields.io/scrutinizer/quality/g/loophp/typed-generators/main.svg?style=flat-square
[type coverage]: https://img.shields.io/badge/dynamic/json?style=flat-square&color=color&label=Type%20coverage&query=message&url=https%3A%2F%2Fshepherd.dev%2Fgithub%2Floophp%2Fiterators%2Fcoverage
[code coverage]: https://img.shields.io/scrutinizer/coverage/g/loophp/typed-generators/main.svg?style=flat-square
[license]: https://img.shields.io/packagist/l/loophp/typed-generators.svg?style=flat-square
[donate github]: https://img.shields.io/badge/Sponsor-Github-brightgreen.svg?style=flat-square
[donate paypal]: https://img.shields.io/badge/Sponsor-Paypal-brightgreen.svg?style=flat-square
[mutation badge image]: https://img.shields.io/endpoint?style=flat-square&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Floophp%2Ftyped-generators%2Fmain
[mutation badge link]: https://dashboard.stryker-mutator.io/reports/github.com/loophp/typed-generators/main
[1]: https://packagist.org/packages/loophp/typed-generators
[2]: https://github.com/loophp/typed-generators/actions
[3]: https://scrutinizer-ci.com/g/loophp/typed-generators/?branch=main
[4]: https://shepherd.dev/github/loophp/typed-generators
[5]: https://github.com/sponsors/drupol
[6]: https://github.com/loophp/typed-generators/graphs/contributors
[34]: https://github.com/loophp/typed-generators/issues
[35]: https://www.phpunit.de/
[36]: https://github.com/phpro/grumphp
[37]: https://github.com/infection/infection
[38]: https://github.com/phpstan/phpstan
[39]: https://github.com/vimeo/psalm
[43]: https://github.com/loophp/typed-generators/blob/main/CHANGELOG.md
[44]: https://github.com/loophp/typed-generators/commits/main
[45]: https://github.com/loophp/typed-generators/releases
[48]: https://www.php.net/cachingiterator
[49]: https://www.php.net/generator
[tg class]: https://github.com/loophp/typed-generators/blob/main/src/TG.php