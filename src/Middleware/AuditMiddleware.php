<?php

namespace App\Middleware;

use App\Stamp\MessageIdentifierStamp;
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
        $message = $envelope->getMessage();

        if (null === $idStamp = $envelope->last(MessageIdentifierStamp::class)) {
            $envelope = $envelope->with(
                $idStamp = new MessageIdentifierStamp(
                    uniqid('', true)
                )
            );
        }

        if (null !== $envelope->last(ReceivedStamp::class)) {
            echo '['.$idStamp->getId().'] Received '.get_class($message)."<br>\n";
        } else {
            echo '['.$idStamp->getId().'] Dispatched ' . get_class($message) . "<br>\n";
        }

        $envelope = $stack->next()->handle($envelope, $stack);

        if (null !== $envelope->last(HandledStamp::class)) {
            echo '['.$idStamp->getId().'] Handled with '.get_class($message)."<br>\n";
        } else {
            echo '['.$idStamp->getId().'] Sent '.get_class($message)." to transport<br>\n";
        }

        return $envelope;
    }
}
