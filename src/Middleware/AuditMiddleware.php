<?php

namespace App\Middleware;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\Stamp\ReceivedStamp;
use Symfony\Component\Messenger\Stamp\SentStamp;

class AuditMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $id = uniqid();

        if (null !== $envelope->last(ReceivedStamp::class)) {
            echo "[$id] Received " . get_class($envelope->getMessage()) . "<br>\n";
        } else {
            echo "[$id] Dispatching " . get_class($envelope->getMessage()) . "<br>\n";
        }

        $envelope = $stack->next()->handle($envelope, $stack);

        if (null !== $envelope->last(SentStamp::class)) {
            echo "[$id] Sent " . get_class($envelope->getMessage()) . "<br>\n";
        } else if (null !== $envelope->last(HandledStamp::class)) {
            echo "[$id] Handled " . get_class($envelope->getMessage()) . "<br>\n";
        } else {
            echo "[$id] I don't know ".get_class($envelope->getMessage())."<br>\n";
        }

        return $envelope;
    }
}
