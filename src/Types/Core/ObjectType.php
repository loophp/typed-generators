<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Core;

use Iterator;
use loophp\TypedGenerators\Types\TypeGenerator;
use stdClass;

/**
 * @implements TypeGenerator<object>
 */
final class ObjectType implements TypeGenerator
{
    public function __invoke(): object
    {
        return new stdClass();
    }

    /**
     * @return Iterator<int, object>
     */
    public function getIterator(): Iterator
    {
        // @phpstan-ignore-next-line
        while (true) {
            yield $this->__invoke();
        }
    }

    /**
     * @param object $input
     */
    public function identity($input): object
    {
        return $input;
    }

    public static function new(): self
    {
        return new self();
    }
}
