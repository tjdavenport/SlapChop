<?php

namespace SlapChop;

use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Component\Finder\Finder;
use SlapChop\AspectRatioCalculator;

class ResizeTransit
{
    protected $finder;
    protected $height = null;
    protected $width = null;

    private $maintainRatio;

    const IMAGE_REGEX = '/^.?[^\.]+\.(jpe?g|png|gif|tiff)$/';

    public function __construct($maintainRatio = false)
    {
        Image::configure();
        $this->maintainRatio = $maintainRatio;
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

    public function dispatch($targetDir, $destDir)
    {
        $images = $this
            ->finder
            ->files()
            ->in($targetDir)
            ->name(self::IMAGE_REGEX)
        ;

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
            $image->save($destDir . $imageFile->getFilename());
        }
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
}
