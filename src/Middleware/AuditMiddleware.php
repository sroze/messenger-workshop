<?php

namespace App\Middleware;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class AuditMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        echo "Handling ".get_class($envelope->getMessage())."<br>\n";

        $result = $stack->next()->handle($envelope, $stack);

        echo "After ".get_class($envelope->getMessage())."<br>\n";

        return $result;
    }
}
