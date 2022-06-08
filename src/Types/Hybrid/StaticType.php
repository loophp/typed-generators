<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Hybrid;

use loophp\TypedGenerators\Types\AbstractTypeGenerator;
use loophp\TypedGenerators\Types\TypeGenerator;

/**
 * @template T
 *
 * @extends AbstractTypeGenerator<T>
 */
final class StaticType extends AbstractTypeGenerator
{
    /**
     * @var TypeGenerator<T>
     */
    private TypeGenerator $type;

    /**
     * @var T
     */
    private $value;

    /**
     * @param TypeGenerator<T> $type
     * @param T $value
     */
    public function __construct(TypeGenerator $type, $value)
    {
        $this->type = $type;
        $this->value = $value;
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
     * @param TypeGenerator<V> $type
     * @param V $value
     *
     * @return StaticType<V>
     */
    public static function new(TypeGenerator $type, $value): self
    {
        return new self($type, $value);
    }
}
