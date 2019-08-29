<?php


namespace App\GoogleTransport;


use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\TransportFactoryInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;

class GoogleTransportFactory implements TransportFactoryInterface
{
    public function createTransport(string $dsn, array $options, SerializerInterface $serializer): TransportInterface
    {
        return new GoogleTransport($serializer, $dsn);
    }

    public function supports(string $dsn, array $options): bool
    {
        return strpos($dsn, 'http') === 0;
    }
}
