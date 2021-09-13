<?php

require_once(ROOT_DIR. 'Pages/Page.php');
require_once(ROOT_DIR. 'Domain/Access/namespace.php');

class TermsOfServicePage extends Page
{
    public function __construct()
    {
        parent::__construct('TermsOfService');
    }

    public function PageLoad()
    {
        $repo = new TermsOfServiceRepository();
        $tos = $repo->Load();

        if ($tos != null) {
            $this->Set('TermsContent', $tos->Text());
        }
        $this->Display('tos.tpl');
    }
}
