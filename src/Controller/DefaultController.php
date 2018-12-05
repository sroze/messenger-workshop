<?php

namespace App\Controller;

use App\Message\RegisterBet;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
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

        return [];
    }
}
