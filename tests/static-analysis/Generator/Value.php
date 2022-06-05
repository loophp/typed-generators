<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

use loophp\TypedGenerators\Generator\Value;
use loophp\TypedGenerators\Types\Core\BoolType;
use loophp\TypedGenerators\Types\Core\StringType;

include __DIR__ . '/../../../vendor/autoload.php';

/**
 * @param iterable<int, string> $iterable
 */
function foobarIntString(iterable $iterable): void
{
}

foobarIntString(Value::new(StringType::new()));

/**
 * @param iterable<int, bool> $iterable
 */
function foobarIntBool(iterable $iterable): void
{
}

foobarIntBool(Value::new(BoolType::new()));
