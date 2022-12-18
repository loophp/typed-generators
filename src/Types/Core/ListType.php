<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Core;

use loophp\TypedGenerators\Types\AbstractType;
use loophp\TypedGenerators\Types\Type;

/**
 * @template T
 *
 * @extends AbstractType<list<T>>
 */
final class ListType extends AbstractType
{
    /**
     * @var list<Type<T>>
     */
    private array $values = [];

    /**
     * @param Type<T> $v
     */
    public function __construct(Type $v)
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
             * @param Type<T> $type
             *
             * @return T
             */
            static fn (Type $type) => $type(),
            $this->values
        );
    }

    /**
     * @template V
     *
     * @param Type<V> $type
     *
     * @return ListType<T|V>
     */
    public function add(Type $type): self
    {
        // @TODO: See if we can fix this issue in PHPStan/PSalm.
        // There should not be @var annotation here.
        // An issue has been opened: https://github.com/vimeo/psalm/issues/8066
        /** @var ListType<T|V> $clone */
        $clone = clone $this;

        /** @var list<Type<T|V>> $values */
        $values = [...$this->values, ...[$type]];
        $clone->values = $values;

        return $clone;
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
     * @param Type<W> $type
     *
     * @return ListType<W>
     */
    public static function new(Type $type): self
    {
        return new self($type);
    }
}
