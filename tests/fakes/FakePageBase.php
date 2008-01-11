<?php
class FakePageBase implements IPage
{
	public $_RedirectCalled = false;
	public $_RedirectDestination = '';
	
	public function Redirect($destination)
	{
		$this->$_RedirectCalled = true;
		$this->$_RedirectDestination = $destination;
	}
}