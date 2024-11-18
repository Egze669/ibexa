<?php

namespace App\FieldType\MultipleImages;

use Ibexa\Contracts\Core\FieldType\Value as ValueInterface;

final class Value implements ValueInterface
{
    private $images;

    public function __construct($images = null)
    {
        $this->images = $images;
    }
    public function getImages()
    {
        return $this->images;
    }

    public function setImages($images): void
    {
        $this->images = $images;
    }

    public function __toString()
    {
        return "({$this->images})";
    }
}