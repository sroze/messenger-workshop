<?php

namespace App\Exception;

use Symfony\Component\Messenger\Transport\AmqpExt\Exception\RejectMessageExceptionInterface;

class ClientUnauthorized extends \Exception implements RejectMessageExceptionInterface
{
}
