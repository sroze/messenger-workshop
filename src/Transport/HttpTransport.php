<?php

namespace App\Transport;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;

class HttpTransport implements TransportInterface
{
    private $dsn;
    private $serializer;
    private $options;

    public function __construct(SerializerInterface $serializer, array $options, string $dsn)
    {
        $this->serializer = $serializer;
        $this->dsn = $dsn;
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function send(Envelope $envelope): Envelope
    {
        $encoded = $this->serializer->encode(
            $envelope
        );

        HttpClient::create()->request(
            $this->options['method'] ?? 'POST',
            $this->dsn,
            [
                'body' => $encoded['body'],
            ]
        );

        return $envelope;
    }

    public function get(): iterable
    {
    }

    public function ack(Envelope $envelope): void
    {
        // no-op
    }

    public function reject(Envelope $envelope): void
    {
        // no-op
    }
}