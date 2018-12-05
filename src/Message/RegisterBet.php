<?php

namespace App\Message;

class RegisterBet
{
    private $user;
    private $game;
    private $leftScore;
    private $rightScore;

    public function __construct(
        string $user,
        string $game,
        int $leftScore,
        int $rightScore
    )
    {
        $this->user = $user;
        $this->game = $game;
        $this->leftScore = $leftScore;
        $this->rightScore = $rightScore;
    }
}
