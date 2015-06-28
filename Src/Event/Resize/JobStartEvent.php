<?php

namespace SlapChop\Event\Resize;

use Symfony\Component\EventDispatcher\Event;

class JobStartEvent extends Event
{
    public $files;

    public function __construct($files)
    {
        $this->files = $files;
    }
}
