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
        yield PersonYouSawWasNegative::class => [
            'bus' => 'bus_events',
            'from_transport' => 'priority_async',
        ];
        yield PersonYouSawWasPositive::class => [
            'bus' => 'bus_events',
        ];
    }

    public function __invoke($message)
    {
        dump("Send an email about ".get_class($message)." to ".$message->email.".");

        // It takes so long to call the email API...
        sleep(1);

        if (rand(0, 10) > 5) {
            throw new \Exception('Oups, API call failed.');
        }
    }
}
