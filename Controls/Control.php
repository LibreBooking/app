<?php
/**
Copyright 2011-2019 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

abstract class Control
{
	/**
	 * @$var SmartyPage|Smarty
	 */
	protected $smarty = null;

	/**
	 * @var Smarty_Data
	 */
	protected $data = null;

	/**
	 * @param SmartyPage|Smarty $smarty
	 */
	public function __construct(SmartyPage $smarty)
	{
		$this->smarty = $smarty;
		$this->id = uniqid();

		$this->data = $smarty->createData();
	}

	public function Set($var, $value)
	{
		$this->data->assign($var, $value);
	}

	protected function Get($var)
	{
		return $this->data->getTemplateVars($var);
	}

	protected function Display($templateName)
	{
		$tpl = $this->smarty->createTemplate($templateName, $this->data);
		$tpl->display();
	}

	public abstract function PageLoad();
}