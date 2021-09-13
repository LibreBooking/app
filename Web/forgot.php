<?php

define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'Pages/ForgotPwdPage.php');
require_once(ROOT_DIR . 'Presenters/ForgotPwdPresenter.php');

$page = new ForgotPwdPage();

$page->PageLoad();
