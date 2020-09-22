<?php


namespace App\Transport;

use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\TransportFactoryInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpTransportFactory implements TransportFactoryInterface
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function createTransport(string $dsn, array $options, SerializerInterface $serializer): TransportInterface
    {
        return new HttpTransport(
            $this->httpClient,
            $serializer,
            $dsn
        );
    }

    public function supports(string $dsn, array $options): bool
    {
        return strpos($dsn, 'https://') === 0;
    }
}
