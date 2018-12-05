<?php

namespace App\Transport;

use Symfony\Component\Messenger\Transport\TransportFactoryInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class HttpTransportFactory implements TransportFactoryInterface
{
    private $normalizer;

    public function __construct(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function createTransport(string $dsn, array $options): TransportInterface
    {
        return new HttpTransport($this->normalizer, $dsn);
    }

    public function supports(string $dsn, array $options): bool
    {
        return strpos($dsn, 'http') === 0;
    }
}
