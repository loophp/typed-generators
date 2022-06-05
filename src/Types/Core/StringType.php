<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\generators\Types\Core;

use loophp\generators\Types\TypeGenerator;

use function chr;

/**
 * @implements TypeGenerator<string>
 */
final class StringType implements TypeGenerator
{
    private int $length;

    public function __construct(int $length = 1)
    {
        $this->length = $length;
    }

    public function __invoke(): string
    {
        return array_reduce(
            range(1, $this->length),
            static function (string $start): string {
                return $start . chr(random_int(33, 126));
            },
            ''
        );
    }

    /**
     * @param string $input
     */
    public function identity($input): string
    {
        return $input;
    }

    public static function new(int $length = 1): self
    {
        return new self($length);
    }
}
