<?php

namespace App\Message;

class DeleteBet
{
    public $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
