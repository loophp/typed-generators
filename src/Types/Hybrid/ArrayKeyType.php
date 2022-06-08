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
 * @extends AbstractTypeGenerator<string|int>
 */
final class ArrayKeyType extends AbstractTypeGenerator
{
    /**
     * @var TypeGenerator<array-key>
     */
    private TypeGenerator $type;

    public function __construct()
    {
        $this->type = Compound::new(PositiveIntType::new(), UniqidType::new());
    }

    /**
     * @return string|int
     */
    public function __invoke()
    {
        return $this->type->__invoke();
    }

    /**
     * @param string|int $input
     *
     * @return string|int
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
