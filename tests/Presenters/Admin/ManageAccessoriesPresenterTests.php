<?php
/**
 * Copyright 2011-2020 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Pages/Admin/ManageAccessoriesPage.php');

class ManageAccessoriesPresenterTests extends TestBase
{
    /**
     * @var FakeManageAccessoriesPage
     */
    private $page;

    /**
     * @var FakeResourceRepository
     */
    public $resourceRepository;

    /**
     * @var FakeAccessoryRepository
     */
    public $accessoryRepository;

    /**
     * @var ManageAccessoriesPresenter
     */
    private $presenter;

    public function setUp(): void
    {
        parent::setup();

        $this->page = new FakeManageAccessoriesPage();
        $this->resourceRepository = new FakeResourceRepository();
        $this->accessoryRepository = new FakeAccessoryRepository();

        $this->presenter = new ManageAccessoriesPresenter(
            $this->page,
            $this->resourceRepository,
            $this->accessoryRepository);
    }

    public function teardown(): void
    {
        parent::teardown();
    }

    public function testWhenInitializing()
    {
        $accessories = array();
        $resources = array();

        $this->resourceRepository->_AccessoryList = $accessories;

        $this->resourceRepository->_ResourceList = $resources;

        $this->presenter->PageLoad();

        $this->assertEquals($accessories, $this->page->_BoundAccessories);
        $this->assertEquals($resources, $this->page->_BoundResources);
    }

    public function testWhenAdding()
    {
        $name = 'accessory';
        $quantity = 2;

        $expectedAccessory = Accessory::Create($name, $quantity);

        $this->page->_AccessoryName = $name;
        $this->page->_QuantityAvailable = $quantity;

        $this->presenter->AddAccessory();
        
        $this->assertEquals($expectedAccessory, $this->accessoryRepository->_AddedAccessory);
    }

    public function testWhenEditing()
    {
        $id = 1982;
        $name = 'accessory';
        $quantity = 2;
        $credits = 1;
        $peakCredits = 2;
        $creditApplicability = CreditApplicability::RESERVATION;

        $currentAccessory = new Accessory($id, 'lskdjfl', 18181);
        $expectedAccessory = new Accessory($id, $name, $quantity);
        $expectedAccessory->ChangeCredits($credits, $peakCredits, $creditApplicability);

        $this->page->_AccessoryId = $id;
        $this->page->_AccessoryName = $name;
        $this->page->_QuantityAvailable = $quantity;
        $this->page->_Credits = $credits;
        $this->page->_PeakCredits = $peakCredits;
        $this->page->_CreditApplicability = $creditApplicability;

        $this->accessoryRepository->_Accessory = $currentAccessory;

        $this->presenter->ChangeAccessory();

        $this->assertEquals($expectedAccessory, $this->accessoryRepository->_UpdatedAccessory);
    }

    public function testWhenDeleting()
    {
        $id = 1982;

        $this->page->_AccessoryId = $id;

        $this->presenter->DeleteAccessory();
        
        $this->assertEquals($id, $this->accessoryRepository->_DeletedId);
    }
}

class FakeManageAccessoriesPage extends ManageAccessoriesPage
{
    public $_AccessoryId;
    public $_AccessoryName;
    public $_QuantityAvailable;
    public $_Credits;
    public $_PeakCredits;
    public $_CreditApplicability;
    public $_BoundAccessories;
    public $_BoundResources;

    public function GetAccessoryId()
    {
        return $this->_AccessoryId;
    }

    public function GetAccessoryName()
    {
        return $this->_AccessoryName;
    }

    public function GetQuantityAvailable()
    {
        return $this->_QuantityAvailable;
    }

    public function GetCreditCount()
    {
        return $this->_Credits;
    }

    public function GetPeakCreditCount()
    {
        return $this->_PeakCredits;
    }

    public function GetCreditApplicability()
    {
        return $this->_CreditApplicability;
    }

    public function BindAccessories($accessories)
    {
        $this->_BoundAccessories = $accessories;
    }

    public function BindResources($resources)
    {
        $this->_BoundResources = $resources;
    }
}