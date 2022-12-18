<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Core;

use loophp\TypedGenerators\Types\AbstractType;

use function chr;

/**
 * @extends AbstractType<string>
 */
final class StringType extends AbstractType
{
    public function __construct(private int $length = 1, private string $prefix = '')
    {
    }

    public function __invoke(): string
    {
        return array_reduce(
            range(1, $this->length),
            static fn(string $start): string => $start . chr(random_int(33, 126)),
            $this->prefix
        );
    }

    /**
     * @param string $input
     */
    public function identity($input): string
    {
        return $input;
    }

    public static function new(int $length = 1, string $prefix = ''): self
    {
        return new self($length, $prefix);
    }
}
