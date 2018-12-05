<?php

namespace App\Transport;

use GuzzleHttp\Client;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\TransportInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class HttpTransport implements TransportInterface
{
    private $url;
    private $normalizer;

    public function __construct(NormalizerInterface $normalizer, string $url)
    {
        $this->url = $url;
        $this->normalizer = $normalizer;
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
                'json' => $this->normalizer->normalize(
                    $envelope->getMessage()
                ),
            ]
        );

        return $envelope;
    }
}
