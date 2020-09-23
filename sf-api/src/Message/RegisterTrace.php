<?php

namespace App\Message;

class RegisterTrace
{
    private $person;
    private $saw;

    public function __construct(
        string $person,
        string $saw
    )
    {
        $this->person = $person;
        $this->saw = $saw;
    }

    public function getPerson(): string
    {
        return $this->person;
    }

    public function getPersonThatWasSeen(): string
    {
        return $this->saw;
    }
}
