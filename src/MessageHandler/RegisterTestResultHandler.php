<?php

namespace App\MessageHandler;

use App\Entity\Trace;
use App\Message\PersonYouSawWasNegative;
use App\Message\PersonYouSawWasPositive;
use App\Message\RegisterTestResult;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class RegisterTestResultHandler implements MessageHandlerInterface
{
    private $entityManager;
    private $messageBus;

    public function __construct(
        EntityManagerInterface $entityManager,
        MessageBusInterface $busEvents
    )
    {
        $this->entityManager = $entityManager;
        $this->messageBus = $busEvents;
    }

    public function __invoke(RegisterTestResult $message)
    {
        $repository = $this->entityManager->getRepository(Trace::class);
        $peopleWhoSawPerson = $repository->findBy([
            'sawEmail' => $message->person,
        ]);

        foreach ($peopleWhoSawPerson as $trace) {
            if ($message->result === 'positive') {
                $this->messageBus->dispatch(new PersonYouSawWasPositive(
                    $trace->personEmail
                ));
            } else {
                $this->messageBus->dispatch(new PersonYouSawWasNegative(
                    $trace->personEmail
                ));
            }
        }
    }
}