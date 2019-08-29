<?php

namespace App\Stamp;

use Symfony\Component\Messenger\Stamp\StampInterface;

class MessageIdentifierStamp implements StampInterface
{
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
