<?php

class Report_Usage
{
	const RESOURCES = 'RESOURCES';
	const ACCESSORIES = 'ACCESSORIES';

	/**
	 * @var Report_Usage|string
	 */
	private $usage;

	/**
	 * @param $usage string|Report_Usage
	 */
	public function __construct($usage)
	{
		$this->usage = $usage;
	}

	public function Add(ReportCommandBuilder $builder)
	{
		if ($this->usage == self::ACCESSORIES)
		{
			$builder->OfAccessories();
		}
		else
		{
			$builder->OfResources();
		}
	}

	public function __toString()
	{
		return $this->usage;
	}
}
