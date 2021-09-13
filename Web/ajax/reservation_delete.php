<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Ajax/ReservationDeletePage.php');

$page = DeleteReservationPageFactory::Create();
$page->PageLoad();

class DeleteReservationPageFactory
{
    public static function Create()
    {
        if (ServiceLocator::GetServer()->GetQuerystring(QueryStringKeys::RESPONSE_TYPE) == 'json') {
            return new ReservationDeleteJsonPage();
        } else {
            return new ReservationDeletePage();
        }
    }
}
