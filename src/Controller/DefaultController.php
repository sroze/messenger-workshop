<?php

namespace App\Controller;

use App\Message\GetBets;
use App\Message\RegisterBet;
use App\Message\ReportResult;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController
{
    /**
     * @Route("/")
     * @Template
     */
    public function home(
        Request $request,
        MessageBusInterface $messageBus
    )
    {
        if ($request->isMethod('post')) {
            $messageBus->dispatch(new RegisterBet(
                $request->get('user'),
                $request->get('game'),
                $request->request->getInt('leftScore'),
                $request->request->getInt('rightScore')
            ));
        }

        $envelope = $messageBus->dispatch(new GetBets());
        /** @var HandledStamp $handledStamp */
        $handledStamp = $envelope->last(HandledStamp::class);

        return [
            'bets' => $handledStamp->getResult(),
        ];
    }

    /**
     * @Route("/report", name="report", methods={"POST"})
     */
    public function report(
        Request $request,
        MessageBusInterface $messageBus
    ) {
        $messageBus->dispatch(new ReportResult(
            $request->request->get('game'),
            $request->request->getInt('leftScore'),
            $request->request->getInt('rightScore')
        ));

        return new Response('OK');
    }
}
