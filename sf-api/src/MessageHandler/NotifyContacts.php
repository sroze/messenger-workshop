<?php


namespace App\MessageHandler;


use App\Message\PersonYouSawWasNegative;
use App\Message\PersonYouSawWasPositive;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

class NotifyContacts implements MessageSubscriberInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getHandledMessages(): iterable
    {
        yield PersonYouSawWasNegative::class;
        yield PersonYouSawWasPositive::class;
    }

    public function __invoke($message)
    {
        dump("Send an email about ".get_class($message)." to ".$message->email.".");

        // It takes so long to call the email API...
        sleep(1);
    }
}