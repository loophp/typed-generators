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
    private int $length;

    private string $prefix;

    public function __construct(int $length = 1, string $prefix = '')
    {
        $this->length = $length;
        $this->prefix = $prefix;
    }

    public function __invoke(): string
    {
        return array_reduce(
            range(1, $this->length),
            static function (string $start): string {
                return $start . chr(random_int(33, 126));
            },
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
