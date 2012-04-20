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
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');

class ManageAttributesActions
{
    const AddAttribute = 'addAttribute';
}

class ManageAttributesPresenter extends ActionPresenter
{
	/**
	 * @var IManageAttributesPage
	 */
	private $page;


	public function __construct(IManageAttributesPage $page)
	{
		parent::__construct($page);

		$this->page = $page;

        $this->AddAction(ManageAttributesActions::AddAttribute, 'AddAttribute');
	}

	public function PageLoad()
	{

	}

    public function AddAttribute()
    {
        $attributeName = $this->page->GetAttributeName();
        Log::Debug('Adding new attribute named: %s', $attributeName);

        $attribute = CustomAttribute::Create($name, $type, $scope);
    }
}
?>