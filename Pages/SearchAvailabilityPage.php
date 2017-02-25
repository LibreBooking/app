<?php

/**
 * Copyright 2017 Nick Korbel
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

require_once(ROOT_DIR . 'Presenters/SearchAvailabilityPresenter.php');
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Pages/ActionPage.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

interface ISearchAvailabilityPage extends IActionPage
{
    /**
     * @param ResourceDto[] $resources
     */
    public function SetResources($resources);

    /**
     * @param ResourceType[] $resourceTypes
     */
    public function SetResourceTypes($resourceTypes);

    /**
     * @param AvailableOpeningView[] $openings
     */
    public function ShowOpenings($openings);

    /**
     * @return int
     */
    public function GetRequestedHours();

    /**
     * @return int
     */
    public function GetRequestedMinutes();

    /**
     * @return string
     */
    public function GetRequestedRange();

    /**
     * @return string
     */
    public function GetRequestedStartDate();

    /**
     * @return string
     */
    public function GetRequestedEndDate();

    /**
     * @return int[]
     */
    public function GetResources();

    /**
     * @return int
     */
    public function GetResourceType();

    /**
     * @return int
     */
    public function GetMaxParticipants();

    /**
     * @return AttributeFormElement[]
     */
    public function GetResourceAttributeValues();

    /**
     * @return AttributeFormElement[]
     */
    public function GetResourceTypeAttributeValues();

    /**
     * @param Attribute[] $attributes
     */
    public function SetResourceAttributes($attributes);

    /**
     * @param Attribute[] $attributes
     */
    public function SetResourceTypeAttributes($attributes);
}

class SearchAvailabilityPage extends ActionPage implements ISearchAvailabilityPage
{
    /**
     * @var SearchAvailabilityPresenter
     */
    private $presenter;

    public function __construct()
    {
        parent::__construct('FindATime');
        $resourceService = ResourceService::Create();
        $user = ServiceLocator::GetServer()->GetUserSession();

        $this->presenter = new SearchAvailabilityPresenter($this,
            $user,
            $resourceService,
            new ReservationService(new ReservationViewRepository(), new ReservationListingFactory()),
            new ScheduleService(new ScheduleRepository(), $resourceService, new DailyLayoutFactory()));

        $this->Set('Today', Date::Now()->ToTimezone($user->Timezone));
        $this->Set('Tomorrow', Date::Now()->AddDays(1)->ToTimezone($user->Timezone));
    }

    public function ProcessAction()
    {
        $this->presenter->ProcessAction();
    }

    public function ProcessDataRequest($dataRequest)
    {
        // TODO: Implement ProcessDataRequest() method.
    }

    public function ProcessPageLoad()
    {
        $this->presenter->PageLoad();
        $this->Display('SearchAvailability/search-availability.tpl');
    }

    public function SetResources($resources)
    {
        $this->Set('Resources', $resources);
    }

    public function SetResourceTypes($resourceTypes)
    {
        $this->Set('ResourceTypes', $resourceTypes);
    }

    public function ShowOpenings($openings)
    {
        $this->Set('Openings', $openings);
        $this->Display('SearchAvailability/search-availability-results.tpl');
    }

    public function GetRequestedHours()
    {
        return intval($this->GetForm(FormKeys::HOURS));
    }

    public function GetRequestedMinutes()
    {
        return intval($this->GetForm(FormKeys::MINUTES));
    }

    public function GetRequestedRange()
    {
        return $this->GetForm(FormKeys::AVAILABILITY_RANGE);
    }

    public function GetRequestedStartDate()
    {
        return $this->GetForm(FormKeys::BEGIN_DATE);
    }

    public function GetRequestedEndDate()
    {
        return $this->GetForm(FormKeys::END_DATE);
    }

    public function GetResources()
    {
        $resources = $this->GetForm(FormKeys::RESOURCE_ID);
        if (empty($resources))
        {
            return array();
        }

        return $resources;
    }

    public function GetResourceType()
    {
        return $this->GetForm(FormKeys::RESOURCE_TYPE_ID);
    }

    public function GetMaxParticipants()
    {
       return $this->GetForm(FormKeys::MAX_PARTICIPANTS);
    }

    public function GetResourceAttributeValues()
    {
        return AttributeFormParser::GetAttributes($this->GetForm('r' . FormKeys::ATTRIBUTE_PREFIX));
    }

    public function GetResourceTypeAttributeValues()
    {
        return AttributeFormParser::GetAttributes($this->GetForm('rt' . FormKeys::ATTRIBUTE_PREFIX));
    }

    public function SetResourceAttributes($attributes)
    {
       $this->Set('ResourceAttributes', $attributes);
    }

    public function SetResourceTypeAttributes($attributes)
    {
        $this->Set('ResourceTypeAttributes', $attributes);
    }
}