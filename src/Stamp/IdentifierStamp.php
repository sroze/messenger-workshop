<?php

namespace App\Stamp;

use Symfony\Component\Messenger\Stamp\StampInterface;

class IdentifierStamp implements StampInterface
{
    public $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
