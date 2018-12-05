<?php

namespace App\MessageHandler;

use App\Entity\Bet;
use App\Message\GetBets;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetBetsHandler implements MessageHandlerInterface
{
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(GetBets $message)
    {
        return $this->entityManager
            ->getRepository(Bet::class)
            ->findAll()
        ;
    }
}
