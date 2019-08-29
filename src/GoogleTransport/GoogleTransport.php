<?php


namespace App\GoogleTransport;


use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;

class GoogleTransport implements TransportInterface
{
    private $url;
    private $serializer;

    public function __construct(SerializerInterface $serializer, string $url)
    {
        $this->url = $url;
        $this->serializer = $serializer;
    }

    public function send(Envelope $envelope): Envelope
    {
        $client = HttpClient::create();

        $client->request('POST', $this->url, [
            'body' => $this->serializer->encode(
                $envelope
            )
        ]);

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