<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Hybrid;

use loophp\TypedGenerators\Types\AbstractTypeGenerator;
use loophp\TypedGenerators\Types\Core\BoolType;
use loophp\TypedGenerators\Types\Core\NullType;
use loophp\TypedGenerators\Types\TypeGenerator;

/**
 * @template T
 *
 * @extends AbstractTypeGenerator<T|null>
 */
final class Nullable extends AbstractTypeGenerator
{
    /**
     * @var TypeGenerator<T>
     */
    private TypeGenerator $type;

    /**
     * @param TypeGenerator<T> $type
     */
    public function __construct(
        TypeGenerator $type
    ) {
        $this->type = $type;
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
     * @param TypeGenerator<V> $type
     *
     * @return Nullable<V>
     */
    public static function new(TypeGenerator $type): self
    {
        return new self($type);
    }
}
