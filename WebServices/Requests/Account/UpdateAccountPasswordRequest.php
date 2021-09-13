<?php

require_once(ROOT_DIR . 'lib/WebService/JsonRequest.php');

class UpdateAccountPasswordRequest extends JsonRequest
{
    public $currentPassword;
    public $newPassword;

    public static function Example()
    {
        $request = new UpdateAccountPasswordRequest();
        $request->currentPassword = 'plain.text.current.password';
        $request->newPassword = 'plain.text.new.password';

        return $request;
    }
}
