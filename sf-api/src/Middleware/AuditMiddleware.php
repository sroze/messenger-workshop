<?php

namespace App\Middleware;

use App\Stamp\IdStamp;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\Stamp\ReceivedStamp;
use Symfony\Component\Messenger\Stamp\SentStamp;

class AuditMiddleware implements MiddlewareInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        if (null === $id = $envelope->last(IdStamp::class)) {
            $envelope = $envelope->with($id = new IdStamp(rand(0, 100000)));
        }

        $context = [
            'class' => get_class($envelope->getMessage()),
            'id' => $id->id,
        ];

        if ($envelope->last(ReceivedStamp::class) !== null) {
            $this->logger->warning('[{id}] Message {class} was received.', $context);
        } else {
            $this->logger->warning('[{id}] Message {class} was just dispatched by the application.', $context);
        }

        $envelope = $stack->next()->handle($envelope, $stack);

        if ($envelope->last(HandledStamp::class) !== null) {
            $this->logger->warning('[{id}] Message {class} was handled.', $context);
        } else if ($envelope->last(SentStamp::class) !== null) {
            $this->logger->warning('[{id}] Message {class} was sent.', $context);
        }

        return $envelope;
    }
}
