<?php

namespace App\Message;

use App\Entity\Bet;

class Lost implements GameResultMessage
{
    public $bet;

    public function __construct(Bet $bet)
    {
        $this->bet = $bet;
    }
}
