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
		$this->name = $name;
		$this->quantityAvailable = $quantityAvailable;
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
	 * @return int
	 */
	public function GetQuantityAvailable()
	{
		return $this->quantityAvailable;
	}
}

?>