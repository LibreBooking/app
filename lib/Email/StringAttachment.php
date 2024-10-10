<?php

class StringAttachment
{
    public function __construct(
        public readonly string $filename,
        public readonly string $contents
    )
    {
        
    }
}