<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Core;

use Iterator;
use loophp\TypedGenerators\Types\TypeGenerator;

use function count;

/**
 * @template T
 *
 * @implements TypeGenerator<list<T>>
 */
final class ListType implements TypeGenerator
{
    private int $count;

    /**
     * @var TypeGenerator<T>
     */
    private TypeGenerator $value;

    /**
     * @param TypeGenerator<T> $v
     */
    public function __construct(TypeGenerator $v, int $count = 1)
    {
        $this->value = $v;
        $this->count = $count;
    }

    /**
     * @return list<T>
     */
    public function __invoke(): array
    {
        $return = [];

        while (count($return) < $this->count) {
            $return[] = ($this->value)();
        }

        return $return;
    }

    /**
     * @return Iterator<int, list<T>>
     */
    public function getIterator(): Iterator
    {
        // @phpstan-ignore-next-line
        while (true) {
            yield $this->__invoke();
        }
    }

    /**
     * @param list<T> $input
     *
     * @return list<T>
     */
    public function identity($input): array
    {
        return $input;
    }

    /**
     * @template W
     *
     * @param TypeGenerator<W> $type
     *
     * @return ListType<W>
     */
    public static function new(TypeGenerator $type, int $count = 1): self
    {
        return new self($type, $count);
    }
}
