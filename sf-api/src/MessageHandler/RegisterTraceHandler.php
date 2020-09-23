<?php

namespace App\MessageHandler;

use App\Entity\Trace;
use App\Message\RegisterTrace;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RegisterTraceHandler implements MessageHandlerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(RegisterTrace $message)
    {
        $trace = new Trace();
        $trace->personEmail = $message->getPerson();
        $trace->sawEmail = $message->getPersonThatWasSeen();

        $this->entityManager->persist($trace);
        $this->entityManager->flush();

        return $trace;
    }
}
