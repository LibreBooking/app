<?php
/**
Copyright 2012 Nick Korbel

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

require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class ReportingRepositoryTests extends TestBase
{
	/**
	 * @var ReportingRepository
	 */
	private $repository;

	public function setup()
	{
		parent::setup();

		$this->repository = new ReportingRepository();
	}

	public function testRunsBuiltCommand()
	{
		$builder = new ReportCommandBuilder();
		$expected = $builder->Build();

		$expectedRows = array(array('c' => 'v'));
		$this->db->SetRows($expectedRows);

		$rows = $this->repository->GetCustomReport($builder);

		$this->assertEquals($expected, $this->db->_LastCommand);
		$this->assertEquals($expectedRows, $rows);
	}
}
?>