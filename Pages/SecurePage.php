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

require_once(ROOT_DIR . 'Pages/Page.php');
require_once(ROOT_DIR . 'lib/Config/namespace.php');

class SecurePage extends Page
{
	public function __construct($titleKey = '', $pageDepth = 0)
	{
		parent::__construct($titleKey, $pageDepth);

		if (!$this->IsAuthenticated())
		{
			$this->Redirect($this->GetResumeUrl());
			die();
		}
	}
	
	protected function GetResumeUrl()
	{
		return sprintf("%s%s?%s=%s", $this->path, Pages::LOGIN, QueryStringKeys::REDIRECT, $this->server->GetUrl());
	}
}
?>