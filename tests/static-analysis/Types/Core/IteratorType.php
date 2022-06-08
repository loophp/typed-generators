<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

use Faker\Generator;
use loophp\TypedGenerators\Types\Core\IteratorType;
use loophp\TypedGenerators\Types\Core\StringType;
use loophp\TypedGenerators\Types\Hybrid\Faker;

/**
 * @param iterable<string, string> $iterable
 *
 * @return iterable<string, string> $iterable
 */
function foobar(iterable $iterable): iterable
{
    return $iterable;
}

$fakerType = Faker::new(
    StringType::new(),
    static function (Generator $faker): string {
        return $faker->city();
    }
);

foobar(IteratorType::new(StringType::new(), $fakerType)());
