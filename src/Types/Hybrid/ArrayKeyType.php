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
 * @extends AbstractType<string|int>
 */
final class ArrayKeyType extends AbstractType
{
    /**
     * @var Type<array-key>
     */
    private Type $type;

    public function __construct()
    {
        $this->type = Union::new(PositiveIntType::new(), UniqidType::new());
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
     */
    public function identity($input): string|int
    {
        return $this->type->identity($input);
    }

    public static function new(): self
    {
        return new self();
    }
}
