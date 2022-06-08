<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Hybrid;

use loophp\TypedGenerators\Types\AbstractTypeGenerator;
use loophp\TypedGenerators\Types\Core\StringType;
use loophp\TypedGenerators\Types\TypeGenerator;

/**
 * @extends AbstractTypeGenerator<string>
 */
final class UniqidType extends AbstractTypeGenerator
{
    /**
     * @var TypeGenerator<string>
     */
    private TypeGenerator $type;

    public function __construct(string $prefix = '', bool $moreEntropy = false)
    {
        $this->type = Custom::new(
            StringType::new(),
            static fn (): string => uniqid($prefix, $moreEntropy)
        );
    }

    public function __invoke(): string
    {
        return $this->type->__invoke();
    }

    /**
     * @param string $input
     */
    public function identity($input): string
    {
        return $this->type->identity($input);
    }

    public static function new(string $prefix = '', bool $moreEntropy = false): self
    {
        return new self($prefix, $moreEntropy);
    }
}
