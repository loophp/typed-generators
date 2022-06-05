<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Hybrid;

use loophp\TypedGenerators\Types\Core\BoolType;
use loophp\TypedGenerators\Types\TypeGenerator;

/**
 * @template T
 * @template U
 *
 * @implements TypeGenerator<T|U>
 */
final class Compound implements TypeGenerator
{
    /**
     * @var TypeGenerator<T>
     */
    private TypeGenerator $t1;

    /**
     * @var TypeGenerator<U>
     */
    private TypeGenerator $t2;

    /**
     * @param TypeGenerator<T> $t1
     * @param TypeGenerator<U> $t2
     */
    public function __construct(
        TypeGenerator $t1,
        TypeGenerator $t2
    ) {
        $this->t1 = $t1;
        $this->t2 = $t2;
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
     * @param TypeGenerator<V> $t1
     * @param TypeGenerator<W> $t2
     *
     * @return Compound<V, W>
     */
    public static function new(TypeGenerator $t1, TypeGenerator $t2): self
    {
        return new self($t1, $t2);
    }
}
