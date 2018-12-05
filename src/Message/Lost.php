<?php

namespace App\Message;

use App\Entity\Bet;

class Lost implements GameResultMessage
{
    private $bet;

    public function __construct(Bet $bet)
    {
        $this->bet = $bet;
    }

    public function getBet()
    {
        return $this->bet;
    }
}
