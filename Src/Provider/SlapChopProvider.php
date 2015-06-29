<?php

namespace SlapChop\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Finder\Finder;
use SlapChop\Event\Resize\Listener      as ResizeListener;
use SlapChop\Event\Resize\JobStartEvent as ResizeJobStartEvent;
use SlapChop\Event\Resize\JobEndEvent   as ResizeJobEndEvent;
use SlapChop\Event\Resize\MoveEvent     as ResizeMoveEvent;

class SlapChopProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['resizeDispatcher'] = function ($c) {

            $dispatcher = new EventDispatcher();
            $listener = new ResizeListener();

            $dispatcher->addListener('resize.jobstart', [$listener, 'onJobStart']);
            $dispatcher->addListener('resize.jobend', [$listener, 'onJobEnd']);
            $dispatcher->addListener('resize.move', [$listener, 'onMove']);

            return $dispatcher;
        };

        $pimple['resizeEvents'] = function ($c) {

            return [
                'jobstart' => function(Finder $files) use ($c) {
                    $c['resizeDispatcher']->dispatch('resize.jobstart', new ResizeJobStartEvent($files));
                },
                'move' => function($image) use ($c) {
                    $c['resizeDispatcher']->dispatch('resize.move', new ResizeMoveEvent($image));
                },
                'jobend' => function() use ($c) {
                    $c['resizeDispatcher']->dispatch('resize.jobend', new ResizeJobEndEvent());
                }

            ];

        };

    }

    private function registerResize($pimplt)
    {
    }
}


