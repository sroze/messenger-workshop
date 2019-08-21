<?php

namespace App\Transport;

use GuzzleHttp\Client;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;

class HttpTransport implements TransportInterface
{
    private $serializer;
    private $url;

    public function __construct(SerializerInterface $serializer, string $url)
    {
        $this->serializer = $serializer;
        $this->url = $url;
    }

    public function receive(callable $handler): void
    {
    }

    public function stop(): void
    {
    }

    /**
     * Sends the given envelope.
     */
    public function send(Envelope $envelope): Envelope
    {
        (new Client())->post(
            $this->url,
            [
                'json' => $this->serializer->encode($envelope)['body'],
            ]
        );

        return $envelope;
    }

    public function get(): iterable
    {
    }

    public function ack(Envelope $envelope): void
    {
    }

    public function reject(Envelope $envelope): void
    {
    }
}
