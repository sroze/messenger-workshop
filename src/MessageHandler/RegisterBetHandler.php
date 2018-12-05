<?php

namespace App\MessageHandler;

use App\Message\RegisterBet;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RegisterBetHandler implements MessageHandlerInterface
{
    public function __invoke(RegisterBet $message)
    {
        var_dump($message);
    }
}
