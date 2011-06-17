<?php
require_once(ROOT_DIR . 'Domain/Access/namespace.php' );
require_once(ROOT_DIR . 'Pages/SecurePage.php');

class AutoCompletePage extends SecurePage
{
	private $listMethods = array();

	public function __construct()
	{
		parent::__construct();
		
	    $this->listMethods[AutoCompleteType::User] = 'GetUsers';
	    $this->listMethods[AutoCompleteType::Group] = 'GetGroups';
	}

	public function PageLoad()
	{
		$results = $this->GetResults($this->GetType(), $this->GetSearchTerm());

		Log::Debug(sprintf('AutoComplete: %s results found for search type: %s, term: %s', count($results), $this->GetType(), $this->GetSearchTerm()));

		$this->SetJson($results);
	}

	private function GetResults($type, $term)
	{
		if (array_key_exists($type, $this->listMethods))
		{
			$method = $this->listMethods[$type];
			return $this->$method($term);
		}

		Log::Debug("AutoComplete for type: $type not defined");
		
		return '';
	}

	public function GetType()
	{
		return $this->GetQuerystring(QueryStringKeys::AUTOCOMPLETE_TYPE);
	}

	public function GetSearchTerm()
	{
		return $this->GetQuerystring(QueryStringKeys::AUTOCOMPLETE_TERM);
	}

	private function GetUsers($term)
	{
		$filter = new LikeSqlFilter(ColumnNames::FIRST_NAME, $term);
		$filter->_Or(new LikeSqlFilter(ColumnNames::LAST_NAME, $term));

		$r = new UserRepository();
		return $r->GetList(1, 100, null, null, $filter)->Results();
	}

	private function GetGroups($term)
	{
		$filter = new LikeSqlFilter(ColumnNames::GROUP_NAME, $term);
		$r = new GroupRepository();
		return $r->GetList(1, 100, null, null, $filter)->Results();
	}
}

class AutoCompleteType
{
	const User = 'user';
	const Group = 'group';
}

?>
