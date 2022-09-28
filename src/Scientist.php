<?php
declare(strict_types=1);

namespace Ferror\Scientist;

use Doctrine\DBAL\Driver\Connection;
use Psr\Log\LoggerInterface;
use Throwable;

class Scientist
{
    private $feature;
    private $current;

    public function __construct(
        private Voter $voter,
        private LoggerInterface $logger,
        private Connection $connection,
    )
    {
    }

    public function try(callable $feature): static
    {
        $this->feature = $feature;

        return $this;
    }

    public function current(callable $current): static
    {
        $this->current = $current;

        return $this;
    }

    public function run(): void
    {
        if ($this->voter->isTrue()) {
            try {
                //start transaction
                $this->connection->beginTransaction();

                //execute new code
                ($this->feature)();

                //end transaction
                $this->connection->commit();

                return;
            } catch (Throwable $e) {
                //rollback changes
                $this->connection->rollBack();

                //log it
                $this->logger->error($e->getMessage());
            }
        }

        //execute old code
        ($this->current)();
    }
}