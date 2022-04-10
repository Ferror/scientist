<?php
declare(strict_types=1);

namespace Ferror\Scientist;

class Voter
{
    public function __construct(
        private bool $bool,
    )
    {
    }

    public function isTrue(): bool
    {
        return $this->bool;
    }
}