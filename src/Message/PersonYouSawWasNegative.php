<?php

namespace App\Message;

class PersonYouSawWasNegative
{
    public $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }
}
