<?php

require_once(ROOT_DIR . 'Controls/Control.php');

class CheckboxControl extends Control
{
    public function PageLoad()
    {
        $this->Set('name', FormKeys::Evaluate($this->Get('name-key')));
        $this->Set('label', Resources::GetInstance()->GetString($this->Get('label-key')));
        $this->Display('Controls/Checkbox.tpl');
    }
}
