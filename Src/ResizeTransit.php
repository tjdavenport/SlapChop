<?php

namespace SlapChop;

use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Component\Finder\Finder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use SlapChop\AspectRatioCalculator;

class ResizeTransit
{
    protected $finder;
    protected $height = null;
    protected $width = null;
    protected $targetDir;
    protected $destDir;
    protected $container = null;
    private $maintainRatio;

    const IMAGE_REGEX = '/^.?[^\.]+\.(jpe?g|png|gif|tiff)$/';

    public function __construct()
    {
        Image::configure();
        $this->finder = new Finder();
    }

    public function setMaintainRatio($maintainRatio)
    {
        $this->maintainRatio = $maintainRatio;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }
    
    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function setTargetDir($dir)
    {
        $this->targetDir = $dir;
    }

    public function setDestDir($dir)
    {
        $this->destDir = $dir;
    }

    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function dispatch()
    {
        $images = $this
            ->finder
            ->files()
            ->in($this->targetDir)
            ->name(self::IMAGE_REGEX)
        ;

        $this->dispatchEvent('jobstart', $images);

        foreach ($images as $imageFile) {
            $image = Image::make($imageFile->getPathname());
            $width = $this->width;
            $height = $this->height;

            if ($width === null) {
                $width = $this->determineWidth($this->height, $image);
            }

            if ($height === null) {
                $height = $this->determineHeight($this->width, $image);
            }

            $image->resize($width, $height);
            $image->save($this->destDir . $imageFile->getFilename());
            $this->dispatchEvent('move', $image);
        }

        $this->dispatchEvent('jobend');
    }

    protected function configure(array $options)
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'targetDir' => getcwd(),
            'maintainRatio' => true,
            'height' => null,
            'width' => null
        ]);
        $resolver->setRequired(['destDir', 'container']);
        $resolver->setAllowedValues('destDir', function($value) {
            return file_exists($value);
        });
        $resolver->setAllowedValues('container', ['Container']);
        $resolvedOptions = $resolver->resolve($options);
    }

    private function determineWidth($newHeight, $image)
    {
        if ($this->maintainRatio) {
            $calc = new AspectRatioCalculator($image->width(), $image->height());
            return $calc->newWidth($newHeight);
        }

        return $image->width();
    }

    private function determineHeight($newWidth, $image)
    {
        if ($this->maintainRatio) {
            $calc = new AspectRatioCalculator($image->width(), $image->height());
            return $calc->newHeight($newWidth);
        }

        return $image->height();
    }

    private function dispatchEvent($eventName, $eventParam = null)
    {
        if ($this->container !== null) {
            $events = $this->container['resizeEvents'];
            $events[$eventName]($eventParam);
        }
    }
}
