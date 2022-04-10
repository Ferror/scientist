<?php
declare(strict_types=1);

namespace Ferror\Scientist;

use Psr\Log\LoggerInterface;

class Scientist
{
    private $feature;
    private $current;

    public function __construct(
        private Voter $voter,
        private LoggerInterface $logger,
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

    public function run()
    {
        if ($this->voter->isTrue()) {
            try {
                //start transaction
                ($this->feature)();
                //end transaction

                return;
            } catch (\Throwable $e) {
                //rollback changes
                //log it
                $this->logger->error($e->getMessage());
            }
        }

        //execute old code
        ($this->current)();
    }
}