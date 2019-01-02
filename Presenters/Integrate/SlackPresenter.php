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

require_once(ROOT_DIR . 'Pages/Integrate/SlackPage.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');

class SlackPresenter
{
    /**
     * @var ISlackPage
     */
    private $page;

    /**
     * @var IResourceRepository
     */
    private $resourceRepository;

    public function __construct(ISlackPage $page, IResourceRepository $resourceRepository)
    {
        $this->page = $page;
        $this->resourceRepository = $resourceRepository;
    }

    public function PageLoad()
    {
        Log::Debug('post %s', var_export($_POST, true));
        $command = $this->page->GetCommand();
        $text = $this->page->GetText();
        $token = $this->page->GetToken();

        if (!$this->ValidateToken($token)) {
            Log::Debug('Invalid Slack token. Provided token: %s', $token);
            $this->page->BindError();
            return;
        }

        $resource = BookableResource::Null();

        if (!empty($text)) {
            $resource = $this->resourceRepository->LoadByName($text);
        }

        $url = new Url(Configuration::Instance()->GetScriptUrl());
        $url->Add(Pages::RESERVATION);

        if ($resource->GetId() != null) {
            $url->AddQueryString(QueryStringKeys::RESOURCE_ID, $resource->GetId());
        }

        $response = new SlackBookResponse($resource->GetName(), $url->ToString());

        $this->page->BindResponse($response);
    }

    private function ValidateToken($token)
    {
        $expectedToken = Configuration::Instance()->GetSectionKey(ConfigSection::SLACK, ConfigKeys::SLACK_TOKEN);

        return !empty($expectedToken) && !empty($token) && $expectedToken == $token;
    }
}

class SlackResponse
{
    /**
     * @var string
     */
    public $text;
    /**
     * @var SlackAttachment[]
     */
    public $attachments = array();
    /**
     * {
     * "text": "Book now",
     * "attachments": [
     * {
     * "fallback": "Book https://flights.example.com/book/r123456",
     * "actions": [
     * {
     * "type": "button",
     * "text": "Book Now",
     * "url": "https://flights.example.com/book/r123456",
     * "style": "primary"
     * }
     * ]
     * }
     * ]
     * }
     */
}

class SlackAttachment
{
    /**
     * @var string
     */
    public $fallback;
    /**
     * @var SlackAction[]
     */
    public $actions = array();

    public function __construct($buttonText, $buttonUrl)
    {
        $this->fallback = $buttonText . ' ' . $buttonUrl;
        $this->actions[] = new SlackAction($buttonText, $buttonUrl);
    }
}

class SlackAction
{
    /**
     * @var string
     */
    public $type = 'button';
    /**
     * @var string
     */
    public $text;
    /**
     * @var string
     */
    public $url;
    /**
     * @var string
     */
    public $style = 'primary';

    public function __construct($buttonText, $buttonUrl)
    {
        $this->text = $buttonText;
        $this->url = $buttonUrl;
    }
}

class SlackBookResponse extends SlackResponse
{
    public function __construct($resourceName, $url)
    {
        $resources = Resources::GetInstance();

        if (!empty($resourceName)) {
            $this->text = $resources->GetString('SlackBookResource', $resourceName);
        }
        else {
            $this->text = $resources->GetString('SlackNotFound');
        }
        $this->attachments[] = new SlackAttachment($resources->GetString('SlackBookNow'), $url);
    }
}