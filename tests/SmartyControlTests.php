<?php
require_once(ROOT_DIR . 'lib/Common/SmartyControls/namespace.php');

class SmartyControlTests extends PHPUnit_Framework_TestCase
{
	private $_server;
	private $_attributes = 'style="font-size:12px;" class="something"';
	private $_templateVar = 'something';
	private $_formKey = 'FIRST_NAME';
	private $_smarty;
	private $_expectedValue = 'expected___value';
	private $_expectedName;
	private $_expectedStyle;
	
	public function setUp()
	{
		$this->_expectedName = FormKeys::FIRST_NAME;
		$this->_server = new FakeServer();
		ServiceLocator::SetServer($this->_server);
		$this->_smarty = new FakeSmarty();
		$this->_smarty->_Value = $this->_expectedValue;
	}
	
	public function tearDown()
	{
		$this->_server = null;
		$this->_smarty = null;
	}
	
	public function testSmartyTextboxWithoutPostback()
	{
		$textbox = new SmartyTextbox($this->_formKey, $this->_templateVar, $this->_attributes, $this->_smarty);
		$expectedHtml = $this->BuildExpectedSmartyTextbox();
		
		$this->assertEquals($expectedHtml, $textbox->Html());	
	}	
	
	public function testSmartyTextboxWithPostback()
	{
		$this->_server->SetForm($this->_expectedName, $this->_expectedValue);
		$this->_smarty->_Value = 'somewrongvalue';
		
		$textbox = new SmartyTextbox($this->_formKey, $this->_templateVar, $this->_attributes, $this->_smarty);
		$expectedHtml = $this->BuildExpectedSmartyTextbox();
		
		$this->assertEquals($expectedHtml, $textbox->Html());
	}
	
	public function testSmartyTextboxForPassword()
	{
		$textbox = new SmartyPasswordbox($this->_formKey, $this->_templateVar, $this->_attributes, $this->_smarty);
		$expectedHtml = $this->BuildExpectedSmartyTextbox('password');
		
		$this->assertEquals($expectedHtml, $textbox->Html());
	}
	
	private function BuildExpectedSmartyTextbox($type = 'text')
	{
		$expectedName = $this->_expectedName;
		$expectedValue = $this->_expectedValue;
		$expectedStyle = $this->_expectedStyle;
		return "<input type=\"$type\" name=\"$expectedName\" id=\"$expectedName\" value=\"$expectedValue\" style=\"font-size:12px;\" class=\"something\" />";			
	}
}

?>