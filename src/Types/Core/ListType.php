<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Core;

use Iterator;
use loophp\TypedGenerators\Types\TypeGenerator;

/**
 * @template T
 *
 * @implements TypeGenerator<list<T>>
 */
final class ListType implements TypeGenerator
{
    /**
     * @var list<TypeGenerator<T>>
     */
    private array $values = [];

    /**
     * @param TypeGenerator<T> $v
     */
    public function __construct(TypeGenerator $v)
    {
        $this->values[] = $v;
    }

    /**
     * @return list<T>
     */
    public function __invoke(): array
    {
        return array_map(
            /**
             * @param TypeGenerator<T> $type
             *
             * @return T
             */
            static fn (TypeGenerator $type) => $type(),
            $this->values
        );
    }

    /**
     * @template V
     *
     * @param TypeGenerator<V> $type
     *
     * @return ListType<T|V>
     */
    public function add(TypeGenerator $type): self
    {
        // @TODO: See if we can fix this issue in PHPStan/PSalm.
        // There should not be @var annotation here.
        // An issue has been opened: https://github.com/vimeo/psalm/issues/8066
        /** @var ListType<T|V> $clone */
        $clone = clone $this;

        /** @var list<TypeGenerator<T|V>> $values */
        $values = array_merge($this->values, [$type]);
        $clone->values = $values;

        return $clone;
    }

    /**
     * @return Iterator<int, list<T>>
     */
    public function getIterator(): Iterator
    {
        /** @phpstan-ignore-next-line */
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
    public static function new(TypeGenerator $type): self
    {
        return new self($type);
    }
}
