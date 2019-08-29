<?php

namespace App\Controller;

use App\Message\DeleteBet;
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
    private $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @Route("/")
     * @Template
     */
    public function home(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->messageBus->dispatch(new RegisterBet(
                $request->get('user'),
                $request->get('game'),
                $request->request->getInt('leftScore'),
                $request->request->getInt('rightScore')
            ));
        }

        $envelope = $this->messageBus->dispatch(new GetBets());
        /** @var HandledStamp $handledStamp */
        $handledStamp = $envelope->last(HandledStamp::class);

        return [
            'bets' => $handledStamp->getResult(),
        ];
    }

    /**
     * @Route("/report", name="report", methods={"POST"})
     */
    public function report(Request $request)
    {
        $this->messageBus->dispatch(new ReportResult(
            $request->request->get('game'),
            $request->request->getInt('leftScore'),
            $request->request->getInt('rightScore')
        ));

        return new Response('<html><body>Reported.</body></html>');
    }

    /**
     * @Route("/report/{id}/delete", name="delete_bet")
     */
    public function delete(Request $request)
    {
        $this->messageBus->dispatch(new DeleteBet(
            $request->get('id')
        ));

        return new Response('<html><body>Deleted successfully!</body></html>');
    }
}
