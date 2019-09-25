<?php


namespace App\Message;

use App\Entity\Bet;

interface BetResult
{
    public function getBet(): Bet;
}
