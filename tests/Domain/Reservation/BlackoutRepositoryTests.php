<?php

require_once(ROOT_DIR . 'Domain/Access/BlackoutRepository.php');

class BlackoutRepositoryTests extends TestBase
{
	/**
	 * @var BlackoutRepository
	 */
	private $repository;

	public function setup()
	{
		parent::setup();

		$this->repository = new BlackoutRepository();
	}

	public function testCanAddNewBlackout()
	{
		$seriesId = 9909870;
		$userId = 123;
		$resourceId = 555;
		$title = 'title';
		$start = Date::Parse('2000-01-01 4:44:44');
		$end = Date::Parse('2000-02-01 13:22:33');
		$date = new DateRange($start, $end);

		$blackout = Blackout::Create($userId, $resourceId, $title, $date);

		$this->db->_ExpectedInsertId = $seriesId;

		$this->repository->Add($blackout);

		$addBlackoutCommand = new AddBlackoutCommand($userId, $resourceId, $title);
		$addBlackoutInstanceCommand = new AddBlackoutInstanceCommand($seriesId, $start, $end);

		$this->assertEquals($addBlackoutCommand, $this->db->_Commands[0]);
		$this->assertEquals($addBlackoutInstanceCommand, $this->db->_Commands[1]);
	}
}

?>