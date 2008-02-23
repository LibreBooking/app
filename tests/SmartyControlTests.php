<?php
require_once('../lib/Common/SmartyControls/namespace.php');
require_once('PHPUnit/Framework.php');

class SmartyControlTests extends PHPUnit_Framework_TestCase
{
	private $_server;
	private $_class = 'someclass';
	private $_templateVar = 'something';
	private $_formKey = 'FIRST_NAME';
	private $_smarty;
	private $_expectedValue = 'expected___value';
	private $_expectedName;
	
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
		$textbox = new SmartyTextbox($this->_formKey, $this->_class, $this->_templateVar, $this->_smarty);
		$expectedHtml = $this->BuildExpectedSmartyTextbox();
		
		$this->assertEquals($expectedHtml, $textbox->Html());	
	}	
	
	public function testSmartyTextboxWithPostback()
	{
		$this->_server->SetForm($this->_expectedName, $this->_expectedValue);
		$this->_smarty->_Value = 'somewrongvalue';
		
		$textbox = new SmartyTextbox($this->_formKey, $this->_class, $this->_templateVar, $this->_smarty);
		$expectedHtml = $this->BuildExpectedSmartyTextbox();
		
		$this->assertEquals($expectedHtml, $textbox->Html());
	}
	
	private function BuildExpectedSmartyTextbox()
	{
		$expectedName = $this->_expectedName;
		$expectedValue = $this->_expectedValue;
		return "<input type=\"text\" class=\"{$this->_class}\" name=\"$expectedName\" id=\"$expectedName\" value=\"$expectedValue\" />";			
	}
}

?>