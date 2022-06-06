<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

use loophp\TypedGenerators\Types\Core\BoolType;
use loophp\TypedGenerators\Types\Core\ListType;
use loophp\TypedGenerators\Types\Core\StringType;

/**
 * @param iterable<int, string> $iterable
 */
function foobarIntString(iterable $iterable): void
{
}

foobarIntString(ListType::new(StringType::new())());

/**
 * @param iterable<int, bool> $iterable
 */
function foobarIntBool(iterable $iterable): void
{
}

foobarIntBool(ListType::new(BoolType::new())());
