<?php
/**
 * Copyright 2018 Nick Korbel
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

require_once(ROOT_DIR . 'Presenters/Admin/ManageEmailTemplatesPresenter.php');

class ManageEmailTemplatesPresenterTests extends TestBase
{
    /**
     * @var FakeManageEmailTemplatesPage
     */
    private $page;

    /**
     * @var ManageEmailTemplatesPresenter
     */
    private $presenter;

    public function setup()
    {
        parent::setup();

        $this->page = new FakeManageEmailTemplatesPage();
        $this->presenter = new ManageEmailTemplatesPresenter($this->page);
    }

    public function testShowsAvailableTemplates()
    {
        $this->fileSystem->_Files = array(
            '/some/path/help.tpl',
            '/some/path/help-admin.tpl',
            '/some/path/file1.tpl',
            '/some/path/file2.tpl',
            '/some/path/file2-custom.tpl');

        $this->presenter->PageLoad();

        $this->assertEquals(array(new EmailTemplateFile('file1', 'file1.tpl'), new EmailTemplateFile('file2', 'file2.tpl')), $this->page->_BoundTemplateNames);
    }

    public function testLoadsRequestedTemplate()
    {
        $contents = "{* copyright
        copyright
        *}
        template contents here";

        $this->page->_TemplateName = 'file1.tpl';
        $this->page->_Language = 'en_us';
        $this->fileSystem->_Exists = false;
        $this->fileSystem->_ExpectedContents[Paths::EmailTemplates('en_us') . $this->page->_TemplateName] = $contents;

        $this->presenter->LoadTemplate();

        $this->assertEquals($contents, $this->page->_BoundTemplateContents);
    }

    public function testLoadsCustomTemplate()
    {
        $contents = 'contents';
        $this->page->_Language = 'en_us';
        $this->fileSystem->_Exists[Paths::EmailTemplates('en_us') . 'file1-custom.tpl'] = true;
        $this->page->_TemplateName = 'file1.tpl';

        $this->fileSystem->_ExpectedContents[Paths::EmailTemplates('en_us') . 'file1-custom.tpl'] = $contents;

        $this->presenter->LoadTemplate();

        $this->assertEquals($contents, $this->page->_BoundTemplateContents);
    }

    public function testUpdatesEmailTemplate()
    {
        $contents = 'new email contents';
        $templateName = 'template.tpl';
        $this->page->_UpdatedTemplateName = $templateName;
        $this->page->_TemplateContents = $contents;
        $this->page->_Language = 'en_us';

        $this->presenter->UpdateEmailTemplate();

        $this->assertEquals($contents, $this->fileSystem->_AddedFileContents);
        $this->assertEquals(Paths::EmailTemplates('en_us'), $this->fileSystem->_AddedFilePath);
        $this->assertEquals('template-custom.tpl', $this->fileSystem->_AddedFileName);
    }
}

class FakeManageEmailTemplatesPage extends ManageEmailTemplatesPage
{
    public $_BoundTemplateNames = array();
    public $_TemplateName;
    public $_UpdatedTemplateName;
    public $_BoundTemplateContents;
    public $_TemplateContents;
    public $_Language;
    public $_SaveResult = true;

    public function BindTemplateNames($templates)
    {
        $this->_BoundTemplateNames = $templates;
    }

    public function BindTemplate($templateContents)
    {
        $this->_BoundTemplateContents = $templateContents;
    }

    public function GetTemplateName()
    {
        return $this->_TemplateName;
    }

    public function GetUpdatedTemplateName()
    {
        return $this->_UpdatedTemplateName;
    }

    public function GetTemplateContents()
    {
        return $this->_TemplateContents;
    }

    public function GetLanguage()
    {
        return $this->_Language;
    }

    public function SetSaveResult($saveResult)
    {
        $this->_SaveResult = $saveResult;
    }
}