<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Hybrid;

use Closure;
use loophp\TypedGenerators\Types\AbstractTypeGenerator;
use loophp\TypedGenerators\Types\TypeGenerator;

/**
 * @template T
 *
 * @extends AbstractTypeGenerator<T>
 */
final class Custom extends AbstractTypeGenerator
{
    /**
     * @var Closure(TypeGenerator<T>): T
     */
    private Closure $generator;

    /**
     * @var TypeGenerator<T>
     */
    private TypeGenerator $type;

    /**
     * @param TypeGenerator<T> $type
     * @param Closure(TypeGenerator<T>): T $generator
     */
    public function __construct(TypeGenerator $type, Closure $generator)
    {
        $this->type = $type;
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
     * @param TypeGenerator<V> $type
     * @param Closure(TypeGenerator<V>): V $generator
     *
     * @return Custom<V>
     */
    public static function new(TypeGenerator $type, Closure $generator): self
    {
        return new self($type, $generator);
    }
}
