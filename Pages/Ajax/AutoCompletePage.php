<?php
require_once(ROOT_DIR . 'Domain/Access/namespace.php' );
require_once(ROOT_DIR . 'Pages/SecurePage.php');

class AutoCompletePage extends SecurePage
{
	public function PageLoad()
	{
		$r = new UserRepository();
		$results = $r->GetList(1, 100, 'first', 'desc', $filterCriteria)->Results();
		$this->SetJson($results);
	}

	public function GetType()
	{
		return $this->GetQuerystring(QueryStringKeys::AUTOCOMPLETE_TYPE);
	}
}

?>
