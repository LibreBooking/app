<?php
/**
 * Copyright 2018-2019 Nick Korbel
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

require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Pages/IPageable.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/Admin/CreditLogPresenter.php');

interface ICreditLogPage extends IPageable
{
    /**
     * @return int
     */
    public function GetUserId();

    /**
     * @param CreditLogView[] $credits
     */
    public function BindCredits($credits);

    /**
     * @param string $fullName
     */
    public function BindUserName($fullName);

    /**
     * @return void
     */
    public function ShowError();
}

class CreditLogPage extends ActionPage implements ICreditLogPage
{
    /**
     * @var CreditLogPresenter
     */
    private $presenter;
    private $pageable;

    public function __construct()
    {
        $this->pageable = new PageablePage($this);

        $this->presenter = new CreditLogPresenter($this, new CreditRepository(), new UserRepository());
        parent::__construct('CreditHistory', 1);
    }

    public function ProcessAction()
    {
    }

    public function ProcessDataRequest($dataRequest)
    {
    }

    public function ProcessPageLoad()
    {
        $this->presenter->PageLoad(ServiceLocator::GetServer()->GetUserSession());

        $this->Display('Admin/Users/credit_log.tpl');
    }

    function GetPageNumber()
    {
        return $this->pageable->GetPageNumber();
    }

    function GetPageSize()
    {
        return $this->pageable->GetPageSize();
    }

    function BindPageInfo(PageInfo $pageInfo)
    {
        $this->Set('PageInfo', $pageInfo);
    }

    public function GetUserId()
    {
        return $this->GetQuerystring(QueryStringKeys::USER_ID);
    }

    public function BindCredits($credits)
    {
        $this->Set('CreditLog', $credits);
    }

    public function BindUserName($fullName)
    {
        $this->Set('UserName', $fullName);
    }

    public function ShowError()
    {
        $this->Set('ShowError', true);
    }
}