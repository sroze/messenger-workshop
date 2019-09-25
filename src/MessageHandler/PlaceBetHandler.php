<?php

namespace App\MessageHandler;

use App\Entity\Bet;
use App\Message\PlaceBet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class PlaceBetHandler implements MessageHandlerInterface
{
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function __invoke(PlaceBet $message)
    {
        $bet = new Bet();
        $bet->game = $message->game;
        $bet->user = $message->user;
        $bet->leftScore = $message->leftScore;
        $bet->rightScore = $message->rightScore;

        $this->entityManager->persist($bet);
        $this->entityManager->flush();
    }
}
