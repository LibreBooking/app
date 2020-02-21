<?php
/**
Copyright 2011-2020 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Common/SmartyControls/namespace.php');

class SmartyControlTests extends TestBase
{
	private $_server;
	private $_attributes = 'style="font-size:12px;" class="something"';
	private $_templateVar = 'something';
	private $_formKey = 'FIRST_NAME';
	private $_smarty;
	private $_expectedValue = 'expected___value';
	private $_expectedName;
	private $_expectedStyle;
	private $_id = "id";

	public function setUp(): void
	{
		$this->_expectedName = FormKeys::FIRST_NAME;
		$this->_server = new FakeServer();
		ServiceLocator::SetServer($this->_server);
		$this->_smarty = new FakeSmarty();
		$this->_smarty->_Value = $this->_expectedValue;
	}

	public function teardown(): void
	{
		$this->_server = null;
		$this->_smarty = null;
	}

	public function testSmartyTextboxWithoutPostback()
	{
		$textbox = new SmartyTextbox($this->_formKey, null, $this->_id, $this->_templateVar, $this->_attributes, false, $this->_smarty);
		$expectedHtml = $this->BuildExpectedSmartyTextbox();

		$this->assertEquals($expectedHtml, $textbox->Html());
	}

	public function testSmartyTextboxWithPostback()
	{
		$this->_server->SetForm($this->_expectedName, $this->_expectedValue);
		$this->_smarty->_Value = 'somewrongvalue';

		$textbox = new SmartyTextbox($this->_formKey, null, $this->_id, $this->_templateVar, $this->_attributes, false, $this->_smarty);
		$expectedHtml = $this->BuildExpectedSmartyTextbox();

		$this->assertEquals($expectedHtml, $textbox->Html());
	}

	public function testSmartyTextboxForPassword()
	{
		$textbox = new SmartyPasswordbox($this->_formKey, null, $this->_id, $this->_templateVar, $this->_attributes, false, $this->_smarty);
		$expectedHtml = $this->BuildExpectedSmartyTextbox('password');

		$this->assertEquals($expectedHtml, $textbox->Html());
	}

	private function BuildExpectedSmartyTextbox($type = 'text')
	{
		$expectedName = $this->_expectedName;
		$expectedValue = $this->_expectedValue;
		$expectedStyle = $this->_expectedStyle;
		return "<input type=\"$type\" name=\"$expectedName\" id=\"{$this->_id}\" value=\"$expectedValue\" style=\"font-size:12px;\" class=\"something\" />";
	}
}