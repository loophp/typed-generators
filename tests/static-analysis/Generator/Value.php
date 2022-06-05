<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

use loophp\generators\Generator\Value;
use loophp\generators\Types\Core\BoolType;
use loophp\generators\Types\Core\StringType;

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
