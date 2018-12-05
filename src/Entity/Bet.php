<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Bet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column
     */
    public $id;

    /**
     * @ORM\Column
     */
    public $user;

    /**
     * @ORM\Column
     */
    public $game;

    /**
     * @ORM\Column(type="integer")
     */
    public $leftScore;

    /**
     * @ORM\Column(type="integer")
     */
    public $rightScore;

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
