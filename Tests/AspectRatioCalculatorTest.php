<?php

use SlapChop\AspectRatioCalculator;

class AspectRatioCalculatorTest extends PHPUnit_Framework_TestCase
{
    public $calc;

    public function __construct()
    {
        parent::__construct();
    }

    public function setUp()
    {
        $this->calc = new AspectRatioCalculator(1920, 1080);
    }

    public function tearDown()
    {
        unset($this->calc);
    }

    public function testNewHeight()
    {
        $this->assertEquals($this->calc->newHeight(10), 6);
        $this->assertEquals($this->calc->newHeight(100), 56);
        $this->assertEquals($this->calc->newHeight(1000), 563);
        $this->assertEquals($this->calc->newHeight(12), 7);
        $this->assertEquals($this->calc->newHeight(123), 69);
        $this->assertEquals($this->calc->newHeight(1234), 694);
        $this->assertEquals($this->calc->newHeight(7), 4);
        $this->assertEquals($this->calc->newHeight(78), 44);
        $this->assertEquals($this->calc->newHeight(789), 444);
        $this->assertEquals($this->calc->newHeight(78910), 44387);
    }

    public function testNewWidth()
    {
        $this->assertEquals($this->calc->newWidth(6), 11);
        $this->assertEquals($this->calc->newWidth(56), 100);
        $this->assertEquals($this->calc->newWidth(563), 1001);
        $this->assertEquals($this->calc->newWidth(7), 12);
        $this->assertEquals($this->calc->newWidth(69), 123);
        $this->assertEquals($this->calc->newWidth(694), 1234);
        $this->assertEquals($this->calc->newWidth(4), 7);
        $this->assertEquals($this->calc->newWidth(44), 78);
        $this->assertEquals($this->calc->newWidth(444), 789);
        $this->assertEquals($this->calc->newWidth(44387), 78910);
    }

    public function testGetRatio()
    {
        $this->assertEquals($this->calc->getRatio(), 1920 / 1080);
    }
}
