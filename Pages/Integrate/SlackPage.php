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

require_once (ROOT_DIR . 'Pages/Page.php');
require_once (ROOT_DIR . 'Presenters/Integrate/SlackPresenter.php');
require_once (ROOT_DIR . 'Domain/Access/namespace.php');

interface ISlackPage
{
    /**
     * @return string
     */
    public function GetCommand();

    /**
     * @return string
     */
    public function GetText();

    /**
     * @return string
     */
    public function GetToken();

    /**
     * @param SlackResponse $response
     */
    public function BindResponse(SlackResponse $response);

    /**
     * @return void
     */
    public function BindError();
}

class SlackPage extends Page implements ISlackPage
{
    /**
     * @var SlackPresenter
     */
    private $presenter;

    public function __construct()
    {
        parent::__construct(null, 1);
        $this->presenter = new SlackPresenter($this, new ResourceRepository());
    }

    public function PageLoad()
    {
        $this->presenter->PageLoad();
    }

    public function GetCommand()
    {
        return $this->GetForm(FormKeys::SLACK_COMMAND);
    }

    public function GetText()
    {
        return $this->GetForm(FormKeys::SLACK_TEXT);
    }

    public function GetToken()
    {
        return $this->GetForm(FormKeys::SLACK_TOKEN);
    }

    public function BindResponse(SlackResponse $response)
    {
        $this->SetJson($response);
    }

    public function BindError()
    {
        $this->SetJson('Command not supported', null, 500);
    }
}