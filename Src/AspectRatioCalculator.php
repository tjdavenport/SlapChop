<?php

namespace SlapChop;

class AspectRatioCalculator
{
    private $ratio;
    private $height;
    private $width;

    public function __construct($width, $height)
    {
        $this->ratio = $width / $height;
        $this->width = $width;
        $this->height = $height;
    }

    public function getRatio()
    {
        return $this->ratio;
    }

    public function newHeight($newWidth)
    {
        return round($this->height / $this->width * $newWidth);
    }
    
    public function newWidth($newHeight)
    {
        return round($this->width / $this->height * $newHeight);
    }
}
