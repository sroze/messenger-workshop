<?php

namespace App\Message;

use App\Entity\Bet;

class LostBet implements BetResult
{
    private $entity;

    public function __construct(Bet $bet)
    {
        $this->entity = $bet;
    }

    /**
     * @return Bet
     */
    public function getBet(): Bet
    {
        return $this->entity;
    }
}