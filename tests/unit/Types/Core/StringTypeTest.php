<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\generators\Types\Core;

use loophp\generators\Types\Core\StringType;
use PHPUnit\Framework\TestCase;
use function strlen;

/**
 * @internal
 * @coversDefaultClass \loophp\generators
 */
final class StringTypeTest extends TestCase
{
    public function stringTypeProvider()
    {
        yield [
            'length' => null,
        ];

        yield [
            'length' => 1,
        ];

        yield [
            'length' => 2,
        ];

        yield [
            'length' => 3,
        ];

        yield [
            'length' => 4,
        ];
    }

    /**
     * @dataProvider stringTypeProvider
     */
    public function testConstructor(?int $length = null)
    {
        $stringType = null === $length
            ? StringType::new()()
            : StringType::new($length)();

        self::assertEquals($length ?? 1, strlen($stringType));
    }
}
