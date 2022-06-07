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

## Installation

```composer require loophp/typed-generators```

## Usage

### Generate list of values

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

### Generate KeyValue pairs

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

### Integration with Faker

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

### Use random compound values

Compound values are values that can be either of type `A` or type `B`.

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

### Generate a complex typed array shape

```php
<?php

declare(strict_types=1);

namespace Snippet;

use Faker\Generator;
use loophp\TypedGenerators\TG;

include __DIR__ . '/vendor/autoload.php';

$countries = TG::faker(
    TG::string(),
    static fn (Generator $faker): string => $faker->country()
);

$cities = TG::faker(
    TG::string(),
    static fn (Generator $faker): string => $faker->city()
);

$iterator = TG::arrayShape(
    TG::string(),
    TG::bool()
)->add(
    $countries,
    $cities
)->add(
    TG::int(),
    TG::datetime()
);

/** @psalm-trace $iterator */
foreach ($iterator as $k => $v) {
    dump($v);
}

/**
array:3 [
  "#" => true
  "American Samoa" => "New Cortezside"
  5 => DateTimeImmutable @1194871036 {#64
    date: 2007-11-12 12:37:16.0 UTC (+00:00)
  }
]
array:3 [
  "Q" => false
  "Norway" => "Taraside"
  2 => DateTimeImmutable @1428398249 {#75
    date: 2015-04-07 09:17:29.0 UTC (+00:00)
  }
]
array:3 [
  "X" => true
  "Saint Pierre and Miquelon" => "South Merrittshire"
  2 => DateTimeImmutable @1515321957 {#72
    date: 2018-01-07 10:45:57.0 UTC (+00:00)
  }
]

$ ./vendor/bin/phpstan analyse --level=9 test-gen.php

 1/1 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100%

 ------ --------------------------------------------------------
  Line   test-gen.php
 ------ --------------------------------------------------------
  33     Dumped type: array<string, bool|DateTimeInterface|string>
 ------ --------------------------------------------------------

$ ./vendor/bin/psalm --show-info=true --no-cache test-gen.php
Target PHP version: 7.4 (inferred from composer.json)
Scanning files...
Analyzing files...

I

INFO: Trace - test-gen.php:36:1 - $iterator: loophp\TypedGenerators\Types\Hybrid\ArrayShape<int|string, DateTimeInterface|bool|string> (see https://psalm.dev/224)
```

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
