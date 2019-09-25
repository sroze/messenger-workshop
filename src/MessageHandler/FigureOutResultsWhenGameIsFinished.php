<?php


namespace App\MessageHandler;


use App\Entity\Bet;
use App\Message\GameFinished;
use App\Message\GetBets;
use App\Message\LostBet;
use App\Message\WonBet;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Middleware\DispatchAfterCurrentBusMiddleware;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

class FigureOutResultsWhenGameIsFinished implements MessageHandlerInterface
{
    use HandleTrait;

    private $messageBus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->messageBus = $bus;
    }

    public function __invoke(GameFinished $event)
    {
        $allBets = $this->handle(new GetBets());
        $thisGameBets = array_filter($allBets, function(Bet $bet) use ($event) {
            return $bet->game == $event->game;
        });

        foreach ($thisGameBets as $bet) {
            $this->messageBus->dispatch(
                $bet->leftScore == $event->leftScore
                && $bet->rightScore == $event->rightScore
                    ? new WonBet($bet)
                    : new LostBet($bet),
                [
                    new DispatchAfterCurrentBusStamp(),
                ]
            );
        }
    }
}
