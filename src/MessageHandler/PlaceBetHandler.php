<?php

namespace App\MessageHandler;

use App\Message\PlaceBet;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class PlaceBetHandler implements MessageHandlerInterface
{
    public function __invoke(PlaceBet $message)
    {
        dd($message);
    }
}
