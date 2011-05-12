<?php
require_once(ROOT_DIR . 'Domain/Access/namespace.php' );
require_once(ROOT_DIR . 'Pages/SecurePage.php');

class AutoCompletePage extends SecurePage
{
	public function PageLoad()
	{
		$filter = new LikeSqlFilter(ColumnNames::FIRST_NAME, 'ni');

		$r = new UserRepository();
		$results = $r->GetList(1, 100, null, null, $filter)->Results();

		$this->SetJson($results);
	}

	public function GetType()
	{
		return $this->GetQuerystring(QueryStringKeys::AUTOCOMPLETE_TYPE);
	}
}

?>
