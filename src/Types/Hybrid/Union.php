<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Hybrid;

use loophp\TypedGenerators\Types\AbstractType;
use loophp\TypedGenerators\Types\Core\BoolType;
use loophp\TypedGenerators\Types\Type;

/**
 * @template T
 * @template U
 *
 * @extends AbstractType<T|U>
 */
final class Union extends AbstractType
{
    /**
     * @param Type<T> $t1
     * @param Type<U> $t2
     */
    public function __construct(private Type $t1, private Type $t2)
    {
    }

    /**
     * @return T|U
     */
    public function __invoke()
    {
        return (new BoolType())() ? ($this->t1)() : ($this->t2)();
    }

    /**
     * @param T|U $input
     *
     * @return T|U
     */
    public function identity($input)
    {
        return $input;
    }

    /**
     * @template V
     * @template W
     *
     * @param Type<V> $t1
     * @param Type<W> $t2
     *
     * @return Union<V, W>
     */
    public static function new(Type $t1, Type $t2): self
    {
        return new self($t1, $t2);
    }
}
