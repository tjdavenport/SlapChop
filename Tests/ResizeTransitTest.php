<?php

use SlapChop\ResizeTransit;

class ResizeTransitTest extends PHPUnit_Framework_TestCase
{
    public $transit;
    public $fixturePath;

    public function __construct()
    {
        parent::__construct();
        $ds = DIRECTORY_SEPARATOR;
        $this->fixturePath = getcwd() . $ds . 'Tests' . $ds . 'Fixtures' . $ds . 'images' . $ds;
        $this->destPath = getcwd() . $ds . 'Tests' . $ds . 'Fixtures' . $ds . 'dest' . $ds;
    }

    public function setUp()
    {
        $this->transit = new ResizeTransit();
    }

    public function tearDown()
    {

    }

    public function testDispatch()
    {
        $this->transit->setDimensions(60, 60);
        $this->transit->dispatch($this->fixturePath, $this->destPath);
    }
}
