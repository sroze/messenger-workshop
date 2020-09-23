<?php

namespace App\Message;

class PersonYouSawWasPositive
{
    public $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }
}
