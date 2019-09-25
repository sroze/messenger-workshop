<?php

namespace App\Controller;

use App\Message\GetBets;
use App\Message\PlaceBet;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

class BetController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function home(MessageBusInterface $messageBus)
    {
        $envelope = $messageBus->dispatch(new GetBets());
        $stamp = $envelope->last(HandledStamp::class);

        return [
            'bets' => $stamp->getResult(),
        ];
    }

    /**
     * @Route("/bet", name="place_bet", methods={"POST"})
     */
    public function placeBet(
        Request $request,
        MessageBusInterface $bus
    ) {
        $bus->dispatch(
            new PlaceBet(
                $request->request->get('user'),
                $request->request->get('game'),
                $request->request->getInt('leftScore'),
                $request->request->getInt('rightScore')
            )
        );
        return $this->redirectToRoute('home');
    }
}
