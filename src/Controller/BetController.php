<?php

namespace App\Controller;

use App\Message\PlaceBet;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class BetController
{
    /**
     * @Route("/")
     * @Template()
     */
    public function home()
    {
        return [];
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
    }
}
