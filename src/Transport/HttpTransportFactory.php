<?php

namespace App\Transport;

use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\TransportFactoryInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;

class HttpTransportFactory implements TransportFactoryInterface
{
    public function createTransport(string $dsn, array $options, SerializerInterface $serializer): TransportInterface
    {
        return new HttpTransport($serializer, $options, $dsn);
    }

    public function supports(string $dsn, array $options): bool
    {
        return strpos($dsn, 'https://') === 0;
    }
}