<?php


namespace App\Middleware;


use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\Stamp\ReceivedStamp;

class AuditMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $id = uniqid();

        if (null !== $envelope->last(ReceivedStamp::class)) {
            echo '['.$id.'] Received message "'.get_class($envelope->getMessage()).'"'."\n<br>";
        } else {
            echo '['.$id.'] Dispatched message "'.get_class($envelope->getMessage()).'"'."\n<br>";
        }


        $envelope = $stack->next()->handle($envelope, $stack);

        if ($envelope->last(HandledStamp::class)) {
            echo '[' . $id . '] Handled message "' . get_class($envelope->getMessage()) . '".' . "\n<br>";
        } else {
            echo '[' . $id . '] Sent message "' . get_class($envelope->getMessage()) . '".' . "\n<br>";
        }

        return $envelope;
    }
}