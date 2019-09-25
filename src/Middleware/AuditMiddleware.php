<?php


namespace App\Middleware;


use App\Stamp\IdentifierStamp;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\Stamp\ReceivedStamp;

class AuditMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $stamp = $envelope->last(IdentifierStamp::class);
         if (null === $stamp) {
             $stamp = new IdentifierStamp(uniqid('messages'));

             $envelope = $envelope->with($stamp);
         }

        if (null !== $envelope->last(ReceivedStamp::class)) {
            echo '['.$stamp->id.'] Received message "'.get_class($envelope->getMessage()).'"'."\n<br>";
        } else {
            echo '['.$stamp->id.'] Dispatched message "'.get_class($envelope->getMessage()).'"'."\n<br>";
        }


        $envelope = $stack->next()->handle($envelope, $stack);

        if ($envelope->last(HandledStamp::class)) {
            echo '[' . $stamp->id . '] Handled message "' . get_class($envelope->getMessage()) . '".' . "\n<br>";
        } else {
            echo '[' . $stamp->id . '] Sent message "' . get_class($envelope->getMessage()) . '".' . "\n<br>";
        }

        return $envelope;
    }
}