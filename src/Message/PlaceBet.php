<?php

namespace App\Message;

class PlaceBet
{
    public $user;
    public $game;
    public $leftScore;
    public $rightScore;

    public function __construct(
        string $user,
        string $game,
        int $leftScore,
        int $rightScore
    ) {
        $this->user = $user;
        $this->game = $game;
        $this->leftScore = $leftScore;
        $this->rightScore = $rightScore;
    }
}