<?php
/**
Copyright 2011-2012 Nick Korbel

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

    public function testDeletesBlackout()
    {
        $id = 98123;
        $deleteBlackoutCommand = new DeleteBlackoutCommand($id);

        $this->repository->Delete($id);

        $this->assertEquals($deleteBlackoutCommand, $this->db->_Commands[0]);
    }
}

?>