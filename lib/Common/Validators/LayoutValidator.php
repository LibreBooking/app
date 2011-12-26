<?php

class LayoutValidator extends ValidatorBase implements IValidator
{
	/**
	 * @var string
	 */
	private $reservableSlots;

	/**
	 * @var string
	 */
	private $blockedSlots;

	/**
	 * @param string $reservableSlots
	 * @param string $blockedSlots
	 */
	public function __construct($reservableSlots, $blockedSlots)
	{
		$this->reservableSlots = $reservableSlots;
		$this->blockedSlots = $blockedSlots;
	}

	/**
	 * @return void
	 */
	public function Validate()
	{
		try
		{
			$this->isValid = true;

			$layout = ScheduleLayout::Parse('UTC', $this->reservableSlots, $this->blockedSlots);
			$slots = $layout->GetLayout(Date::Now()->ToUtc());

			/** @var $firstDate Date */
			$firstDate = $slots[0]->BeginDate();
			/** @var $lastDate Date */
			$lastDate = $slots[count($slots) - 1]->EndDate();
			if (!$firstDate->IsMidnight() || !$lastDate->IsMidnight())
			{
				$this->isValid = false;
			}

			for ($i = 0; $i < count($slots) - 1; $i++)
			{
				if (!$slots[$i]->EndDate()->Equals($slots[$i + 1]->BeginDate()))
				{
					$this->isValid = false;
				}
			}
		}
		catch (Exception $ex)
		{
			$this->isValid = false;
		}
	}

}
