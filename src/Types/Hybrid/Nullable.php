<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Hybrid;

use loophp\TypedGenerators\Types\AbstractType;
use loophp\TypedGenerators\Types\Core\BoolType;
use loophp\TypedGenerators\Types\Core\NullType;
use loophp\TypedGenerators\Types\Type;

/**
 * @template T
 *
 * @extends AbstractType<T|null>
 */
final class Nullable extends AbstractType
{
    /**
     * @param Type<T> $type
     */
    public function __construct(private Type $type)
    {
    }

    /**
     * @return T|null
     */
    public function __invoke()
    {
        return (new BoolType())() ? ($this->type)() : NullType::new()();
    }

    /**
     * @param T|null $input
     *
     * @return T|null
     */
    public function identity($input)
    {
        return $input;
    }

    /**
     * @template V
     *
     * @param Type<V> $type
     *
     * @return Nullable<V>
     */
    public static function new(Type $type): self
    {
        return new self($type);
    }
}
