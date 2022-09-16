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
        $connection = $this->createMock(\Doctrine\DBAL\Driver\Connection::class);
        $scientist = new Scientist(
            new Voter(true),
            new NullLogger(),
            $connection,
        );
        $scientist
            ->current(function () {
                echo PHP_EOL . 'First Attempt'  . PHP_EOL;
            })
            ->try(function () {
                echo PHP_EOL . 'Second Attempt' . PHP_EOL;
            })
            ->run();

        self::expectNotToPerformAssertions();
    }
}