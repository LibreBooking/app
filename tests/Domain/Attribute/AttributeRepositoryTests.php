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

require_once(ROOT_DIR . 'Domain/Access/AttributeRepository.php');

class AttributeRepositoryTests extends TestBase
{
    /**
     * @var AttributeRepository
     */
    private $repository;

    public function setup()
    {
        parent::setup();

        $this->repository = new AttributeRepository();
    }

    public function teardown()
    {
        parent::teardown();
    }

    public function testAddsAttribute()
    {
		$label = 'label';
		$type = CustomAttributeTypes::SINGLE_LINE_TEXTBOX;
		$scope = CustomAttributeCategory::RESERVATION;
		$regex = 'regex';
		$required = false;
		$possibleValues = '';

        $attribute = CustomAttribute::Create($label, $type, $scope, $regex, $required, $possibleValues);

        $this->repository->Add($attribute);
        $this->assertEquals(new AddAttributeCommand($label, $type, $scope, $regex, $required, $possibleValues), $this->db->_LastCommand);
    }

    public function testDeletesAttribute()
    {

    }

    public function testLoadsAttribute()
    {

    }



//    private function GetAnnouncementRow($id, $text, $startDate, $endDate, $priority)
//    {
//        return array(
//            ColumnNames::ANNOUNCEMENT_ID => $id,
//            ColumnNames::ANNOUNCEMENT_TEXT => $text,
//            ColumnNames::ANNOUNCEMENT_START => $startDate,
//            ColumnNames::ANNOUNCEMENT_END => $endDate,
//            ColumnNames::ANNOUNCEMENT_PRIORITY => $priority);
//    }
}

?>