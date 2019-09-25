<?php

namespace App\Controller;

use App\Message\GetBets;
use App\Message\LostBet;
use App\Message\PlaceBet;
use App\Message\WonBet;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
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
            foreach ($bets as $bet) {
                if (rand(0, 1000) > 200) {
                    $this->messageBus->dispatch(new LostBet($bet));
                } else {
                    $this->messageBus->dispatch(new WonBet($bet));
                }
            }
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
