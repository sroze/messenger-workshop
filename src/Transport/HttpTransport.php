<?php

namespace App\Transport;

use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpTransport implements TransportInterface
{
    private $httpClient;
    private $serializer;
    private $url;

    public function __construct(
        HttpClientInterface $httpClient,
        SerializerInterface $serializer,
        string $url
    )
    {
        $this->httpClient = $httpClient;
        $this->serializer = $serializer;
        $this->url = $url;
    }

    public function get(): iterable
    {
        throw new \Exception('Not implemented.');
    }

    public function ack(Envelope $envelope): void
    {
        throw new \Exception('Not implemented.');
    }

    public function reject(Envelope $envelope): void
    {
        throw new \Exception('Not implemented.');
    }

    /**
     * {@inheritDoc}
     */
    public function send(Envelope $envelope): Envelope
    {
        $encoded = $this->serializer->encode($envelope);

        $this->httpClient->request(
            'POST',
            $this->url,
            ['body' => $encoded['body']]
        );

        return $envelope;
    }
}
