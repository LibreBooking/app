<?php
/**
Copyright 2011-2013 Nick Korbel

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

require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');

class ServerSettingsPage extends AdminPage
{
	public function __construct()
	{
		parent::__construct('ServerSettings');
	}

	public function PageLoad()
	{
		if ($this->TakingAction())
		{
			$this->ProcessAction();
		}

		$plugins = $this->GetPlugins();

		$uploadDir = new ImageUploadDirectory();
		$cacheDir = new TemplateCacheDirectory();

		$this->Set('plugins', $plugins);
		$this->Set('currentTime', date('Y-m-d, H:i:s (e P)'));
		$this->Set('imageUploadDirPermissions', substr(sprintf('%o', fileperms($uploadDir->GetDirectory())), -4));
		$this->Set('imageUploadDirectory', $uploadDir->GetDirectory());
		$this->Set('tempalteCacheDirectory', $cacheDir->GetDirectory());
		$this->Display('server_settings.tpl');
	}

	function ProcessAction()
	{
		if ($this->GetAction() == 'changePermissions')
		{
			$uploadDir = new ImageUploadDirectory();
			$uploadDir->MakeWriteable();
		}
		else
		{
			$cacheDir = new TemplateCacheDirectory();
			$cacheDir->Flush();
		}

	}

	private function GetPlugins()
	{
		$plugins = array();
		$dit = new RecursiveDirectoryIterator(ROOT_DIR . 'plugins');

		/** @var $path SplFileInfo  */
		foreach($dit as $path)
		{
			if ($path->IsDir() )
			{
				$plugins[basename($path->getPathname())] = array();
				/** @var $plugin SplFileInfo  */
				foreach (new RecursiveDirectoryIterator($path) as $plugin)
				{
					if ($plugin->isDir())
					{
						$plugins[basename($path->getPathname())][] = basename($plugin->getPathname());
					}
				}
			}
		}

		return $plugins;
	}
}

class ImageUploadDirectory
{
	public function GetDirectory()
	{
		$uploadDir = Configuration::Instance()->GetKey(ConfigKeys::IMAGE_UPLOAD_DIRECTORY);
		if (is_dir($uploadDir))
		{
			return $uploadDir;
		}

		return ROOT_DIR .$uploadDir;
	}

	public function MakeWriteable()
	{
		$chmodResult = chmod($this->GetDirectory(), 0770);
	}

}

class TemplateCacheDirectory
{
	public function Flush()
	{
		try
		{
			$dirName = $this->GetDirectory();
			$cacheDir = opendir($dirName);
		    while (false !== ($file = readdir($cacheDir)))
			{
		        if($file != "." && $file != "..")
				{
		            unlink($dirName . $file);
		        }
		    }
		    closedir($cacheDir);
		}
		catch(Exception $ex)
		{
			Log::Error('Could not flush template cache directory: %s', $ex);
		}
	}

	public function GetDirectory()
	{
		return ROOT_DIR . 'tpl_c/';
	}
}
?>