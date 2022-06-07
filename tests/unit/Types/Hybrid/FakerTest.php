<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\TypedGenerators\Types\Hybrid;

use Faker\Generator as FakerGenerator;
use LimitIterator;
use loophp\TypedGenerators\Types\Core\BoolType;
use loophp\TypedGenerators\Types\Hybrid\Faker;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversDefaultClass \loophp\TypedGenerators
 */
final class FakerTest extends TestCase
{
    public function testConstructor()
    {
        $subject = new Faker(
            new BoolType(),
            static fn (FakerGenerator $faker): bool => $faker->boolean()
        );

        self::assertIsBool($subject());
    }

    public function testGetIterator()
    {
        $subject = new Faker(new BoolType(), static fn (FakerGenerator $faker): bool => $faker->boolean());

        self::assertInstanceOf('Iterator', $subject->getIterator());

        $iterator = new LimitIterator($subject->getIterator(), 0, 3);

        self::assertCount(3, iterator_to_array($iterator));
    }

    public function testIdentity()
    {
        $subject = new Faker(new BoolType(), static fn (FakerGenerator $faker): bool => $faker->boolean());

        self::assertTrue($subject->identity(true));
    }
}
