<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Hybrid;

use loophp\TypedGenerators\Types\AbstractTypeGenerator;
use loophp\TypedGenerators\Types\Core\FloatType;
use loophp\TypedGenerators\Types\Core\IntType;
use loophp\TypedGenerators\Types\TypeGenerator;

/**
 * @extends AbstractTypeGenerator<int|float>
 */
final class NumericType extends AbstractTypeGenerator
{
    /**
     * @var Compound<int, float>
     */
    private TypeGenerator $type;

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
