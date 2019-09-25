<?php

namespace App\Controller;

use App\Message\GameFinished;
use App\Message\GetBets;
use App\Message\LostBet;
use App\Message\PlaceBet;
use App\Message\WonBet;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

class BetController extends AbstractController
{
    use HandleTrait;

    private $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function home(Request $request)
    {
        $bets = $this->handle(new GetBets());
        if ($request->isMethod('POST')) {
            $this->messageBus->dispatch(new GameFinished(
                $request->request->get('game'),
                $request->request->getInt('leftScore'),
                $request->request->getInt('rightScore')
            ));
        }

        return [
            'bets' => $bets,
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
