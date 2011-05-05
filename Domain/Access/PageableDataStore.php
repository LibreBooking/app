<?php
class PageableDataStore
{
	/**
	 * @param int $pageNumber
	 * @param int $pageSize
	 * @param string $sortField
	 * @param string $sortDirection
	 * @return PageableData
	 */
	public function GetUsers($pageNumber, $pageSize, $sortField = null, $sortDirection = null)
	{
		$db = ServiceLocator::GetDatabase();

		$allUsersCommand = new GetAllUsersByStatusCommand();
		$total = $db->Query(new CountCommand($allUsersCommand));
		$results = $db->Query($allUsersCommand);

		return new PageableData($results, $total, $pageNumber, $pageSize);
	}
}

class PageableData
{
	public function __construct($results = array(), $total = 0, $pageNumber = 1, $pageSize = 1)
	{

	}

	public function Results()
	{
		return $this->results;
	}
}?>
