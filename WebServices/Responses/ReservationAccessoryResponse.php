<?php

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class ReservationAccessoryResponse extends RestResponse
{
    public $id;
    public $name;
    public $quantityAvailable;
    public $quantityReserved;

    public function __construct(IRestServer $server, $id, $name, $quantityReserved, $quantityAvailable)
    {
        $this->id = $id;
        $this->name = $name;
        $this->quantityReserved = $quantityReserved;
        $this->quantityAvailable = $quantityAvailable;

        $this->AddService($server, WebServices::GetAccessory, [WebServiceParams::AccessoryId => $id]);
    }

    public static function Example()
    {
        return new ExampleReservationAccessoryResponse();
    }
}

class ExampleReservationAccessoryResponse extends ReservationAccessoryResponse
{
    public function __construct()
    {
        $this->id = 1;
        $this->name = 'Example';
        $this->quantityAvailable = 12;
        $this->quantityReserved = 3;
    }
}
