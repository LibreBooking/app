<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

abstract class EmailMessage implements IEmailMessage
{
	/**
	 * @var SmartyPage
	 */
	private $email;
	
	protected function __construct($languageCode = null)
	{
		$resources = new Resources();
		if (!empty($languageCode))
		{
			$resources->SetLanguage($languageCode);
		}
		$this->email = new SmartyPage($resources);
        $this->Set('ScriptUrl', Configuration::Instance()->GetScriptUrl());
        $this->Set('Charset', $resources->Charset);
	}

	protected function Set($var, $value)
	{
		$this->email->assign($var, $value);
	}
	
	protected function FetchTemplate($templateName)
	{
		return $this->email->FetchLocalized($templateName);
	}
	
	protected function Translate($key, $args = array())
	{
		return $this->email->SmartyTranslate(array('key' => $key, 'args' => implode(',', $args)), $this->email);
	}
	
	public function ReplyTo()
	{
		return $this->From();
	}

	public function From()
	{
		return new EmailAddress(Configuration::Instance()->GetKey(ConfigKeys::ADMIN_EMAIL));
	}
	
	public function CC()
	{
		return array();
	}
	
	public function BCC()
	{
		return array();
	}
	
	public function Charset()
	{
		return $this->email->getTemplateVars('Charset');
	}
}
?>