<?php

define('ROOT_DIR', '../../../');

require_once(ROOT_DIR . 'lib/Common/namespace.php');

try
{
	@session_start();
	require_once(ROOT_DIR . 'lib/external/securimage/securimage.php');

	$img = new securimage();

	// configure the captcha display
	$img->image_width = 280;
	$img->image_height = 100;
	$img->code_length = 6;
	$img->image_bg_color = new Securimage_Color("#ffffff");
	$img->text_color = new Securimage_Color("#000000");
	$img->noise_color = $img->text_color;
	$img->line_color = new Securimage_Color("#cccccc");

	$img->show();
}
catch (Exception $ex)
{
	Log::Error('Error showing captcha image: %s', $ex);
}


