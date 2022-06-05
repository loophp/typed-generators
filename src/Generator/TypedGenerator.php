<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\generators\Generator;

use Generator;
use IteratorAggregate;

/**
 * @template TKey
 * @template T
 *
 * @extends IteratorAggregate<TKey, T>
 */
interface TypedGenerator extends IteratorAggregate
{
    /**
     * @return Generator<TKey, T>
     */
    public function getIterator(): Generator;
}
