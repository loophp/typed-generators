<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Hybrid;

use loophp\TypedGenerators\Types\AbstractType;
use loophp\TypedGenerators\Types\Core\FloatType;
use loophp\TypedGenerators\Types\Core\IntType;
use loophp\TypedGenerators\Types\Type;

/**
 * @extends AbstractType<int|float>
 */
final class NumericType extends AbstractType
{
    /**
     * @var Compound<int, float>
     */
    private Type $type;

    public function __construct()
    {
        $this->type = Compound::new(IntType::new(), FloatType::new());
    }

    /**
     * @return int|float
     */
    public function __invoke()
    {
        return $this->type->__invoke();
    }

    /**
     * @param int|float $input
     *
     * @return int|float
     */
    public function identity($input)
    {
        return $this->type->identity($input);
    }

    public static function new(): self
    {
        return new self();
    }
}
