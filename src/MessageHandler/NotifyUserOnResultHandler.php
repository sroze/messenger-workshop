<?php


namespace App\MessageHandler;

use App\Message\BetResult;
use App\Message\LostBet;
use App\Message\WonBet;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

class NotifyUserOnResultHandler implements MessageSubscriberInterface
{
    /**
     * Returns a list of messages to be handled.
     *
     * It returns a list of messages like in the following example:
     *
     *     yield MyMessage::class;
     *
     * It can also change the priority per classes.
     *
     *     yield FirstMessage::class => ['priority' => 0];
     *     yield SecondMessage::class => ['priority => -10];
     *
     * It can also specify a method, a priority, a bus and/or a transport per message:
     *
     *     yield FirstMessage::class => ['method' => 'firstMessageMethod'];
     *     yield SecondMessage::class => [
     *         'method' => 'secondMessageMethod',
     *         'priority' => 20,
     *         'bus' => 'my_bus_name',
     *         'from_transport' => 'your_transport_name',
     *     ];
     *
     * The benefit of using `yield` instead of returning an array is that you can `yield` multiple times the
     * same key and therefore subscribe to the same message multiple times with different options.
     *
     * The `__invoke` method of the handler will be called as usual with the message to handle.
     */
    public static function getHandledMessages(): iterable
    {
        return [ WonBet::class, LostBet::class ];
    }

    public function __invoke($message)
    {
        var_dump('got it', get_class($message));
        echo '<br>';

        sleep(1);
    }
}