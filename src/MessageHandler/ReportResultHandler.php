<?php

namespace App\MessageHandler;

use App\Entity\Bet;
use App\Message\Lost;
use App\Message\ReportResult;
use App\Message\Won;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;

class ReportResultHandler implements MessageHandlerInterface
{
    private $entityManager;
    private $messageBus;

    public function __construct(
        EntityManagerInterface $entityManager,
        MessageBusInterface $eventBus
    ) {
        $this->entityManager = $entityManager;
        $this->messageBus = $eventBus;
    }

    public function __invoke(ReportResult $message)
    {
        $bets = $this->entityManager
            ->getRepository(Bet::class)
            ->findBy([ 'game' => $message->game ])
        ;

        foreach ($bets as $bet) {
            if ($bet->leftScore == $message->leftScore &&
                $bet->rightScore == $message->rightScore) {
                $this->messageBus->dispatch(new Won($bet));
            } else {
                $this->messageBus->dispatch(
                    (new Envelope(new Lost($bet)))
                );
            }
        }
    }
}
