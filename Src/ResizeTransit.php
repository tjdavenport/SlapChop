<?php

namespace SlapChop;

use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Component\Finder\Finder;

class ResizeTransit
{
    protected $finder;
    protected $height;
    protected $width;

    const IMAGE_REGEX = '/^.?[^\.]+\.(jpe?g|png|gif|tiff)$/';

    public function __construct()
    {
        Image::configure();
        $this->finder = new Finder();
    }

    public function setDimensions($height = null, $width = null)
    {
        $this->height = $height;
        $this->width = $width;
    }

    public function dispatch($targetDir, $destDir)
    {
        $images = $this->finder
            ->files()
            ->in($targetDir)
            ->name(self::IMAGE_REGEX)
        ;

        foreach ($images as $imageFile) {
            $image = Image::make($imageFile->getPathname());
            $image->resize($this->width, $this->height);
            $image->save($destDir . $imageFile->getFilename());
        }
    }
}
