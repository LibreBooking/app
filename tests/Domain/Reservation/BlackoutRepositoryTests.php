<?php
/**
Copyright 2011-2013 Nick Korbel

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

	public function testCanAddNewBlackoutSeries()
	{
		$seriesId = 9909870;
		$userId = 123;
		$resourceId = 555;
		$resourceId2 = 5552;
		$title = 'title';
		$start = Date::Parse('2000-01-01 4:44:44');
		$end = Date::Parse('2000-02-01 13:22:33');
		$date = new DateRange($start, $end);

		$series = new BlackoutSeries($userId, $title, $date);
		$series->AddResource($resourceId);
		$series->AddResource($resourceId2);
		$repeatOptions = new RepeatDaily(1, $start->AddDays(2));
		$series->Repeats($repeatOptions);

		$this->db->_ExpectedInsertId = $seriesId;

		$this->repository->Add($series);

		$addBlackoutCommand = new AddBlackoutCommand($userId, $title, $repeatOptions->RepeatType(), $repeatOptions->ConfigurationString());
		$addBlackoutResourceCommand1 = new AddBlackoutResourceCommand($seriesId, $resourceId);
		$addBlackoutResourceCommand2 = new AddBlackoutResourceCommand($seriesId, $resourceId2);
		$addBlackoutInstanceCommand = new AddBlackoutInstanceCommand($seriesId, $start, $end);

		$this->assertEquals($addBlackoutCommand, $this->db->_Commands[0]);
		$this->assertTrue($this->db->ContainsCommand($addBlackoutResourceCommand1));
		$this->assertTrue($this->db->ContainsCommand($addBlackoutResourceCommand2));
		$this->assertTrue($this->db->ContainsCommand($addBlackoutInstanceCommand));
		$this->assertTrue($this->db->ContainsCommand(new AddBlackoutInstanceCommand($seriesId, $start->AddDays(1), $end->AddDays(1))));
	}

    public function testDeletesBlackout()
    {
        $id = 98123;
        $deleteBlackoutCommand = new DeleteBlackoutCommand($id);

        $this->repository->Delete($id);

        $this->assertEquals($deleteBlackoutCommand, $this->db->_Commands[0]);
    }
}

?>