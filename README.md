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

Typed Generators

## Features

## Installation

```composer require loophp/generators```

## Usage

### Generate list of values

```php
<?php

declare(strict_types=1);

namespace Snippet;

use loophp\generators\Generator\KeyValue;
use loophp\generators\Types\Core\BoolType;
use loophp\generators\Types\Core\StringType;

include __DIR__ . '/vendor/autoload.php';

$value = Value::new(
    StringType::new() // Generate strings
);

foreach ($value as $v) {
    var_dump($v); // Random string generated
}
```

### Generate KeyValue pairs

```php
<?php

declare(strict_types=1);

namespace Snippet;

use loophp\generators\Generator\KeyValue;
use loophp\generators\Types\Core\BoolType;
use loophp\generators\Types\Core\StringType;

include __DIR__ . '/vendor/autoload.php';

$keyValue = KeyValue::new(
    StringType::new(), // Generate strings for keys
    BoolType::new()    // Generate booleans for values
);

foreach ($keyValue as $k => $v) {
    var_dump($k, $v); // Random string for key, random boolean for value.
}
```

### Integration with Faker

```php
<?php

declare(strict_types=1);

namespace Snippet;

use Faker\Generator;
use loophp\generators\Generator\KeyValue;
use loophp\generators\Types\Core\StringType;
use loophp\generators\Types\Hybrid\FakerType;

include __DIR__ . '/vendor/autoload.php';

$fakerType = FakerType::new(
    StringType::new(),
    fn (Generator $faker): string => $faker->city()
);

$keyValue = KeyValue::new(
    StringType::new(4), // A random string of length 4
    $fakerType          // A random city name
);

foreach ($keyValue as $k => $v) {
    dump($k, $v);
}
```

### Use random compound values

```php
<?php

declare(strict_types=1);

namespace Snippet;

use Faker\Generator;
use loophp\generators\Generator\KeyValue;
use loophp\generators\Types\Core\BoolType;
use loophp\generators\Types\Core\IntType;
use loophp\generators\Types\Core\StringType;
use loophp\generators\Types\Hybrid\Compound;
use loophp\generators\Types\Hybrid\FakerType;

include __DIR__ . '/vendor/autoload.php';

$fakerType = FakerType::new(
    StringType::new(),
    fn (Generator $faker): string => $faker->firstName()
);

$keyValue = KeyValue::new(
    BoolType::new(),   // A random boolean for keys.
    Compound::new(     // A random compound value for values which can
        $fakerType,    // be either a firstname or an integer.
        IntType::new()
    )
);

foreach ($keyValue as $k => $v) {
    dump($k, $v);
}
```

### Generate a complex array

```php
<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Snippet;

use Faker\Generator;
use loophp\generators\Types\Core\ArrayType;
use loophp\generators\Types\Core\BoolType;
use loophp\generators\Types\Core\StringType;
use loophp\generators\Types\Hybrid\Compound;
use loophp\generators\Types\Hybrid\FakerType;

include __DIR__ . '/vendor/autoload.php';

$complexArray = ArrayType::new(
    StringType::new(),
    ArrayType::new(
        StringType::new(),
        Compound::new(
            BoolType::new(),
            FakerType::new(
                StringType::new(),
                static function (Generator $faker): string {
                    return $faker->city();
                }
            )
        ),
        6
    ),
    2
);

var_dump($complexArray());

/** @psalm-trace $complexArray */

/*
array:2 [
  "*" => array:6 [
    "X" => true
    """ => true
    "p" => false
    "{" => false
    "#" => "West Shyann"
    9 => "Amaliamouth"
  ]
  "s" => array:6 [
    "k" => "Port Nikkistad"
    "F" => "Beahanstad"
    "Q" => "New Skylarton"
    "i" => true
    ":" => "Harrisberg"
    "|" => "Port Nathenmouth"
  ]
]

./vendor/bin/phpstan analyse --level=9 test-gen.php

 1/1 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100%

 ------ --------------------------------------------------------
  Line   test-gen.php
 ------ --------------------------------------------------------
  39     Dumped type: array<string, array<string, bool|string>>
 ------ --------------------------------------------------------

$ ./vendor/bin/psalm --show-info=true --stats --no-cache test-gen.php
Target PHP version: 7.4 (inferred from composer.json)
Scanning files...
Analyzing files...

I

INFO: Trace - test-gen.php:41:0 - $complexArray: loophp\generators\Types\TypeGenerator<array<string, array<string, bool|string>>> (see https://psalm.dev/224)
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

[latest stable version]: https://img.shields.io/packagist/v/loophp/generators.svg?style=flat-square
[github stars]: https://img.shields.io/github/stars/loophp/generators.svg?style=flat-square
[total downloads]: https://img.shields.io/packagist/dt/loophp/generators.svg?style=flat-square
[github workflow status]: https://img.shields.io/github/workflow/status/loophp/generators/Unit%20tests?style=flat-square
[code quality]: https://img.shields.io/scrutinizer/quality/g/loophp/generators/main.svg?style=flat-square
[type coverage]: https://img.shields.io/badge/dynamic/json?style=flat-square&color=color&label=Type%20coverage&query=message&url=https%3A%2F%2Fshepherd.dev%2Fgithub%2Floophp%2Fiterators%2Fcoverage
[code coverage]: https://img.shields.io/scrutinizer/coverage/g/loophp/generators/main.svg?style=flat-square
[license]: https://img.shields.io/packagist/l/loophp/generators.svg?style=flat-square
[donate github]: https://img.shields.io/badge/Sponsor-Github-brightgreen.svg?style=flat-square
[donate paypal]: https://img.shields.io/badge/Sponsor-Paypal-brightgreen.svg?style=flat-square
[mutation badge image]: https://img.shields.io/endpoint?style=flat-square&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Floophp%2Fiterators%2Fmain
[mutation badge link]: https://dashboard.stryker-mutator.io/reports/github.com/loophp/generators/main
[1]: https://packagist.org/packages/loophp/generators
[2]: https://github.com/loophp/generators/actions
[3]: https://scrutinizer-ci.com/g/loophp/generators/?branch=main
[4]: https://shepherd.dev/github/loophp/generators
[5]: https://github.com/sponsors/drupol
[6]: https://github.com/loophp/generators/graphs/contributors
[34]: https://github.com/loophp/generators/issues
[35]: https://www.phpunit.de/
[36]: https://github.com/phpro/grumphp
[37]: https://github.com/infection/infection
[38]: https://github.com/phpstan/phpstan
[39]: https://github.com/vimeo/psalm
[43]: https://github.com/loophp/generators/blob/main/CHANGELOG.md
[44]: https://github.com/loophp/generators/commits/main
[45]: https://github.com/loophp/generators/releases
[48]: https://www.php.net/cachingiterator
[49]: https://www.php.net/generator
