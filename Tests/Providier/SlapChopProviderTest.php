<?php

use SlapChop\Provider\SlapChopProvider;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Pimple\Container;

class SlapChopProviderTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {

    }

    public function tearDown()
    {

    }

    public function testRegister()
    {
        $container = new Container();        
        $container->register(new SlapChopProvider('resize'));

        $this->assertTrue($container['resizeDispatcher'] instanceof EventDispatcher);
    }
}
