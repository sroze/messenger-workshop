<?php

namespace App\MessageHandler;

use App\Message\GameResultMessage;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

class BetResultHandler implements MessageSubscriberInterface
{
    public function handleResult($message)
    {
//        throw new \Exception('Something went wrong.');

        sleep(1);

        echo $message->bet->user." ".get_class($message)."<br>\n";
    }

    public static function getHandledMessages(): iterable
    {
        yield GameResultMessage::class => [
            'method' => 'handleResult',
            'bus' => 'event_bus',
        ];
    }
}
