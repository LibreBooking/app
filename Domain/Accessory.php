<?php

class Accessory
{
	/**
	 * @var int
	 */
	private $id;


	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var int
	 */
	private $quantityAvailable;

	/**
	 * @param int $id
	 * @param string $name
	 * @param int $quantityAvailable
	 */
	public function __construct($id, $name, $quantityAvailable)
	{
		$this->id = $id;
		$this->SetName($name);
		$this->SetQuantityAvailable($quantityAvailable);
	}

	/**
	 * @return int
	 */
	public function GetId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function GetName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return void
	 */
	public function SetName($name)
	{
		$this->name = $name;
	}

	/**
	 * @param int $quantity
	 */
	public function SetQuantityAvailable($quantity)
	{
		$q = intval($quantity);
		$this->quantityAvailable = empty($q) ? null : $q;
	}

	/**
	 * @return int
	 */
	public function GetQuantityAvailable()
	{
		return $this->quantityAvailable;
	}

	/**
	 * @static
	 * @param string $name
	 * @param int $quantity
	 * @return Accessory
	 */
	public static function Create($name, $quantity)
	{
		return new Accessory(null, $name, $quantity);
	}
}

?>