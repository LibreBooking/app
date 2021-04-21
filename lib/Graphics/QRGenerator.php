<?php

require_once(ROOT_DIR . 'lib/external/phpqrcode/qrlib.php');

class QRGenerator
{
    public function SavePng($url, $path)
    {
        QRcode::png($url, $path);
    }
}
