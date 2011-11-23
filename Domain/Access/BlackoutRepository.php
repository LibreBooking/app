<?php
require_once(ROOT_DIR . 'Domain/Blackout.php');

interface IBlackoutRepository
{
	/**
	 * @abstract
	 * @param Blackout $blackout
	 * @return void
	 */
	public function Add(Blackout $blackout);
}

class BlackoutRepository implements IBlackoutRepository
{
	/**
	 * @param Blackout $blackout
	 * @return void
	 */
	public function Add(Blackout $blackout)
	{
		// TODO: Implement Add() method.
	}
}
