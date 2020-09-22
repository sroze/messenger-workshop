<?php

namespace App\Message;

class RegisterTestResult
{
    public $person;
    public $result;

    public function __construct(string $person, string $result)
    {
        $this->person = $person;
        $this->result = $result;
    }
}
