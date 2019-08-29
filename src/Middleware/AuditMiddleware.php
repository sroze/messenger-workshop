<?php

namespace App\Middleware;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class AuditMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();
        $messageId = uniqid('', true);

        echo '['.$messageId.'] Handling '.get_class($message)."<br>\n";

        $result = $stack->next()->handle($envelope, $stack);

        echo '['.$messageId.'] Finished with '.get_class($message)."<br>\n";

        return $result;
    }
}
