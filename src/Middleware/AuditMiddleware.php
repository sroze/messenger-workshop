<?php

namespace App\Middleware;

use App\Stamp\IdentifierStamp;
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
        if (null === $envelope->last(IdentifierStamp::class)) {
            $envelope = $envelope->with(new IdentifierStamp());
            $envelope = $envelope->with(new IdentifierStamp());
        }

        $id = $envelope->last(IdentifierStamp::class)->id;

        $color = substr($id, -6);

        if (null !== $envelope->last(ReceivedStamp::class)) {
            echo "[$color] Received " . get_class($envelope->getMessage()) . PHP_EOL;
        } else {
            echo "<span style='background-color:#$color'>[$color] Dispatching " . get_class($envelope->getMessage()) . "</span><br>\n";
        }

        $envelope = $stack->next()->handle($envelope, $stack);

        if (null !== $envelope->last(SentStamp::class)) {
            echo "<span style='background-color:#$color'>[$color] Sent " . get_class($envelope->getMessage()) . "</span><br>\n";
        } else if (null !== $envelope->last(HandledStamp::class)) {
            echo "<span style='background-color:#$color'>[$color] Handled " . get_class($envelope->getMessage()) . "</span><br>\n";
        } else {
            echo "<span style='background-color:#$color'>[$color] I don't know ".get_class($envelope->getMessage())."</span><br>\n";
        }

        return $envelope;
    }
}
