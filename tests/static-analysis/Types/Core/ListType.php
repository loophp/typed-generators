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
 *
 * @return iterable<int, string> $iterable
 */
function foobarIntString(iterable $iterable): iterable
{
    return $iterable;
}

foobarIntString(ListType::new(StringType::new())());

/**
 * @param iterable<int, bool> $iterable
 *
 * @return iterable<int, bool> $iterable
 */
function foobarIntBool(iterable $iterable): iterable
{
    return $iterable;
}

foobarIntBool(ListType::new(BoolType::new())());
