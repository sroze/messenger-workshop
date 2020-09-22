<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Trace
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column()
     */
    public $id;

    /** @ORM\Column() */
    public $personEmail;

    /** @ORM\Column() */
    public $sawEmail;
}
