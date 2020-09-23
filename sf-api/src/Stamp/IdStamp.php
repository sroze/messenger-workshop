<?php


namespace App\Stamp;


use Symfony\Component\Messenger\Stamp\StampInterface;

class IdStamp implements StampInterface
{
    public int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}