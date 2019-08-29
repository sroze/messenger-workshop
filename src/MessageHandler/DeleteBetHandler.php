<?php

namespace App\MessageHandler;

use App\Entity\Bet;
use App\Message\DeleteBet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteBetHandler implements MessageHandlerInterface
{
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function __invoke(DeleteBet $message)
    {
        $this->entityManager->remove(
            $this->entityManager->find(Bet::class, $message->id)
        );

        $this->entityManager->flush();
    }
}