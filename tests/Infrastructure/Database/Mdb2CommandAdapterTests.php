<?php
/**
Copyright 2011-2017 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'lib/Database/Mdb2/namespace.php');

class Mdb2CommandAdapterTests extends PHPUnit_Framework_TestCase
{
	function testDatabaseQueryLoadsValuesInCorrectOrder() {
		$name1 = 'paramName1';
		$val1 = 'value1';
		$name2 = 'paramName2';
		$val2 = 'value2';

		$cn = new FakeDBConnection();
		$db = new Database($cn);

		$p1 = new Parameter($name1, $val1);
		$p2 = new Parameter($name2, $val2);

		$parameters = new Parameters();
		$parameters->Add($p1);
		$parameters->Add($p2);

		$command = new SqlCommand("SELECT * FROM sometable WHERE col1 = @$name1 AND col2 = @$name2");
		$command->SetParameters($parameters);

		$adapter = new Mdb2CommandAdapter($command);

		$vals = $adapter->GetValues();
		$this->assertEquals(2, count($vals));
		$this->assertEquals($val1, $vals[$name1]);
		$this->assertEquals($val2, $vals[$name2]);
		$this->assertEquals("SELECT * FROM sometable WHERE col1 = :$name1 AND col2 = :$name2", $adapter->GetQuery());
	}
}
?>