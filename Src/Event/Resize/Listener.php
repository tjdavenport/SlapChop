<?php

namespace SlapChop\Event\Resize;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use SlapChop\Event\Resize\JobStartEvent;
use SlapChop\Event\Resize\JobEndEvent;
use SlapChop\Event\Resize\MoveEvent;
use SlapChop\Vince;

class Listener
{
    private $progress;
    private $output;

    public function __construct()
    {
        $this->output = new ConsoleOutput();
    }

    public function onJobStart(JobStartEvent $event)
    {
        $numberOfFiles = iterator_count($event->files);
        $this->output->writeln(Vince::sellIt());
        $this->progress = new ProgressBar($this->output, $numberOfFiles);
        $this->progress->start();
    }

    public function onJobEnd(JobEndEvent $event)
    {
        $this->progress->finish();
        $this->output->writeln("\n");
        $this->output->writeln('Operation successful! You\'re gonna love this thing');
    }

    public function onMove(MoveEvent $event)
    {
        $this->progress->advance();
    }

}
