<?php
/**
 * Copyright 2013-2020 Nick Korbel
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

require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');

class ManageThemePresenter extends ActionPresenter
{
    /**
     * @var ManageThemePage
     */
    private $page;

    public function __construct(ManageThemePage $page)
    {
        parent::__construct($page);
        $this->page = $page;
        $this->AddAction('update', 'UpdateTheme');
        $this->AddAction('removeLogo', 'RemoveLogo');
        $this->AddAction('removeFavicon', 'RemoveFavicon');
    }

    public function UpdateTheme()
    {
        $logoFile = $this->page->GetLogoFile();
        $cssFile = $this->page->GetCssFile();
        $favicon = $this->page->GetFaviconFile();

        if ($logoFile != null) {
            Log::Debug('Replacing logo with ' . $logoFile->OriginalName());

            $this->RemoveLogo();

            $target = ROOT_DIR . 'Web/img/custom-logo.' . $logoFile->Extension();
            $copied = copy($logoFile->TemporaryName(), $target);
            if (!$copied) {
                Log::Error('Could not replace logo with %s. Ensure %s is writable.',
                    $logoFile->OriginalName(), $target);
            }
        }
        if ($cssFile != null) {
            Log::Debug('Replacing css file with ' . $cssFile->OriginalName());
            $target = ROOT_DIR . 'Web/css/custom-style.css';
            $copied = copy($cssFile->TemporaryName(), $target);
            if (!$copied) {
                Log::Error('Could not replace css with %s. Ensure %s is writable.',
                    $cssFile->OriginalName(), $target);
            }
        }
        if ($favicon != null) {
            Log::Debug('Replacing favicon with ' . $favicon->OriginalName());

            $this->RemoveFavicon();

            $target = ROOT_DIR . 'Web/custom-favicon.' . $favicon->Extension();
            $copied = copy($favicon->TemporaryName(), $target);
            if (!$copied) {
                Log::Error('Could not replace favicon with %s. Ensure %s is writable.',
                    $favicon->OriginalName(), $target);
            }
        }
    }

    public function RemoveLogo()
    {
        try {
            $targets = glob(ROOT_DIR . 'Web/img/custom-logo.*');
            foreach ($targets as $target) {
                $removed = unlink($target);
                if (!$removed) {
                    Log::Error('Could not remove existing logo. Ensure %s is writable.', $target);
                }
            }
        } catch (Exception $ex) {
            Log::Error('Could not remove logos. %s', $ex);
        }
    }

    public function RemoveFavicon()
    {
        try {
            $targets = glob(ROOT_DIR . 'Web/custom-favicon.*');
            foreach ($targets as $target) {
                $removed = unlink($target);
                if (!$removed) {
                    Log::Error('Could not remove existing favicon. Ensure %s is writable.', $target);
                }
            }
        } catch (Exception $ex) {
            Log::Error('Could not remove favicon. %s', $ex);
        }
    }

    protected function LoadValidators($action)
    {
        $this->page->RegisterValidator('logoFile', new FileUploadValidator($this->page->GetLogoFile()));
        $this->page->RegisterValidator('logoFileExt', new FileTypeValidator($this->page->GetLogoFile(), array('jpg', 'png', 'gif')));
        $this->page->RegisterValidator('cssFile', new FileUploadValidator($this->page->GetCssFile()));
        $this->page->RegisterValidator('cssFileExt', new FileTypeValidator($this->page->GetCssFile(), 'css'));
        $this->page->RegisterValidator('faviconFile', new FileUploadValidator($this->page->GetFaviconFile()));
        $this->page->RegisterValidator('faviconFileExt', new FileTypeValidator($this->page->GetFaviconFile(), array('ico', 'jpg', 'png', 'gif')));

    }
}
