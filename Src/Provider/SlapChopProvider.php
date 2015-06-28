<?php

namespace SlapChop\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class SlapChopProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['dispatcher'] = function ($c) {
            return new EventDispatcher();
        };
    }
}


