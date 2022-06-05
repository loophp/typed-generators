<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

use Faker\Generator;
use loophp\generators\Generator\KeyValue;
use loophp\generators\Types\Core\StringType;
use loophp\generators\Types\Hybrid\FakerType;

include __DIR__ . '/../../../vendor/autoload.php';

/**
 * @param iterable<string, string> $iterable
 */
function foobar(iterable $iterable): void
{
}

$fakerType = FakerType::new(
    StringType::new(),
    static function (Generator $faker): string {
        return $faker->city();
    }
);

foobar(KeyValue::new(StringType::new(), $fakerType));
