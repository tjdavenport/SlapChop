<?php

namespace SlapChop\Event\Resize;

use Symfony\Component\EventDispatcher\Event;

class MoveEvent extends Event
{
    public $image;

    public function __construct($image)
    {
        $this->image = $image;
    }
}
