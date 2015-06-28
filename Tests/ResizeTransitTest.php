<?php

use SlapChop\ResizeTransit;
use SlapChop\AspectRatioCalculator;
use SlapChop\Provider\SlapChopProvider;
use Symfony\Component\Finder\Finder;
use Pimple\Container;
use Intervention\Image\ImageManagerStatic as Image;

class ResizeTransitTest extends PHPUnit_Framework_TestCase
{
    public $transit;
    public $fixturePath;

    public function __construct()
    {
        parent::__construct();
        Image::configure();
        $ds = DIRECTORY_SEPARATOR;
        $this->fixturePath = getcwd() . $ds . 'Tests' . $ds . 'Fixtures' . $ds . 'images' . $ds;
        $this->destPath = getcwd() . $ds . 'Tests' . $ds . 'Fixtures' . $ds . 'dest' . $ds;
    }

    public function setUp()
    {
        $container = new Container();
        $this->transit = new ResizeTransit();
        $this->transit->setContainer($container->register(new SlapChopProvider()));
    }

    public function tearDown()
    {
        $this->clearDest();
    }

    public function testDispatch()
    {
        $this->transit->setHeight(60);
        $this->transit->setWidth(60);
        $this->transit->dispatch($this->fixturePath, $this->destPath);

        foreach ($this->collect($this->destPath) as $imageFile) {
            $image = Image::make($imageFile->getPathname());
            $this->assertEquals($image->width(), 60);
            $this->assertEquals($image->height(), 60);
        }
    }

    public function testDispatchMaintainAspectRatio()
    {
        $this->transit->setMaintainRatio(true);

        $baseRatios = [];
        foreach($this->collect($this->fixturePath) as $imageFile) {
            $image = Image::make($imageFile->getPathname());
            $baseRatios[] = new AspectRatioCalculator($image->width(), $image->height());
        }

        $this->transit->setHeight(50);
        $this->transit->dispatch($this->fixturePath, $this->destPath);

        $count = 0;
        foreach ($this->collect($this->destPath) as $imageFile) {
            $image = Image::make($imageFile->getPathname());
            $this->assertEquals($image->height(), 50);
            $this->assertEquals($baseRatios[$count]->newWidth(50), $image->width());
            $count++;
        }
    }

    private function collect($path)
    {
        $finder = new Finder();
        return $finder
            ->files()
            ->name(ResizeTransit::IMAGE_REGEX)
            ->in($path)
        ;
    }
    
    private function clearDest()
    {
        foreach ($this->collect($this->destPath) as $imageFile) {
            unlink($imageFile->getPathname());
        }
    }
}
