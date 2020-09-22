<?php

namespace App\Controller;

use App\Message\RegisterTrace;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController
{
    /**
     * @Route("/", name="home")
     * @Template("home.html.twig")
     */
    public function home(Request $request, MessageBusInterface $bus)
    {
        if ($request->isMethod('POST')) {
            $bus->dispatch(new RegisterTrace(
                $request->get('person_email'),
                $request->get('saw_email')
            ));
        }
    }
}
