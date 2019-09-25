<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity() */
class Bet
{
    /**
     * @ORM\Id()
     * @ORM\Column()
     * @ORM\GeneratedValue(strategy="UUID")
     */
    public $id;
    /** @ORM\Column() */
    public $game;
    /** @ORM\Column() */
    public $user;
    /** @ORM\Column() */
    public $leftScore;
    /** @ORM\Column() */
    public $rightScore;
}
