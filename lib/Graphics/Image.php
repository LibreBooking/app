<?php

interface IImage
{
    public function ResizeToWidth($pixels);

    public function Save($path);
}

class Image implements IImage
{
    public function __construct(SimpleImage $image)
    {
        $this->image = $image;
    }

    public function ResizeToWidth($pixels)
    {
        $this->image->resizeToWidth($pixels);
    }

    public function Save($path)
    {
        $this->image->save($path);
    }
}
