<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

abstract class EmailMessage implements IEmailMessage
{
	/**
	 * @var SmartyPage
	 */
	private $email;
	/**
	 * @var string|null
	 */
	private $attachmentContents;
	/**
	 * @var string|null
	 */
	private $attachmentFileName;

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
		if (!is_array($args))
		{
			$args = array($args);
		}
		return $this->email->SmartyTranslate(array('key' => $key, 'args' => implode(',', $args)), $this->email);
	}

	public function ReplyTo()
	{
		return $this->From();
	}

	public function From()
	{
		return new EmailAddress(Configuration::Instance()->GetKey(ConfigKeys::ADMIN_EMAIL), Configuration::Instance()->GetKey(ConfigKeys::ADMIN_EMAIL_NAME));
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

	public function AddStringAttachment($contents, $fileName)
	{
		$this->attachmentContents = $contents;
		$this->attachmentFileName = $fileName;
	}

	public function HasStringAttachment()
	{
		return !empty($this->attachmentContents);
	}

	public function AttachmentContents()
	{
		return $this->attachmentContents;
	}

	public function AttachmentFileName()
	{
		return $this->attachmentFileName;
	}

}

?>