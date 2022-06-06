<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types;

use Iterator;
use IteratorAggregate;

/**
 * @template T
 *
 * @extends IteratorAggregate<int, T>
 */
interface TypeGenerator extends IteratorAggregate
{
    /**
     * @return T
     */
    public function __invoke();

    /**
     * @return Iterator<int, T>
     */
    public function getIterator(): Iterator;

    /**
     * @param T $input
     *
     * @return T
     */
    public function identity($input);
}
