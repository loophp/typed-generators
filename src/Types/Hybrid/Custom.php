<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Hybrid;

use Closure;
use loophp\TypedGenerators\Types\AbstractType;
use loophp\TypedGenerators\Types\Type;

/**
 * @template T
 *
 * @extends AbstractType<T>
 */
final class Custom extends AbstractType
{
    /**
     * @var Closure(Type<T>): T
     */
    private Closure $generator;

    /**
     * @param Type<T> $type
     * @param Closure(Type<T>): T $generator
     */
    public function __construct(private Type $type, Closure $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @return T
     */
    public function __invoke()
    {
        return $this->identity(($this->generator)($this->type));
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
     * @param Closure(Type<V>): V $generator
     *
     * @return Custom<V>
     */
    public static function new(Type $type, Closure $generator): self
    {
        return new self($type, $generator);
    }
}
