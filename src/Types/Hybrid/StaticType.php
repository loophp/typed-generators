<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Hybrid;

use loophp\TypedGenerators\Types\AbstractType;
use loophp\TypedGenerators\Types\Type;

/**
 * @template T
 *
 * @extends AbstractType<T>
 */
final class StaticType extends AbstractType
{
    /**
     * @param Type<T> $type
     * @param T $value
     */
    public function __construct(private Type $type, private $value)
    {
    }

    /**
     * @return T
     */
    public function __invoke()
    {
        return $this->identity($this->value);
    }

    /**
     * @param T $input
     *
     * @return T
     */
    public function identity($input)
    {
        return $this->type->identity($input);
    }

    /**
     * @template V
     *
     * @param Type<V> $type
     * @param V $value
     *
     * @return StaticType<V>
     */
    public static function new(Type $type, $value): self
    {
        return new self($type, $value);
    }
}
