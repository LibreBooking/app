<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');

class ImportPage extends AdminPage
{
    public function __construct()
    {
        parent::__construct('Import', 1);
    }

    public function PageLoad()
    {
        $this->Display('Import/import.tpl');
    }
}

$page = new ImportPage();
$page->PageLoad();
