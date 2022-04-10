<?php
declare(strict_types=1);

namespace Ferror\Scientist\Unit;

use Ferror\Scientist\Scientist;
use Ferror\Scientist\Voter;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class ScientistTest extends TestCase
{
    public function testBehaviour(): void
    {
        $scientist = new Scientist(
            new Voter(true),
            new NullLogger(),
        );
        $scientist
            ->current(function () {
                echo "First Attempt\n";
            })
            ->try(function () {
                echo "Second Attempt\n";
            })
            ->run();

        self::expectNotToPerformAssertions();
    }
}