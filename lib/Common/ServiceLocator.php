<?php
/**
Copyright 2011-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

class ServiceLocator
{
    /**
     * @var Database
     */
    private static $_database = null;

    /**
     * @var Server
     */
    private static $_server = null;

    /**
     * @var IEmailService
     */
    private static $_emailService = null;

	/**
	 * @var \Booked\IFileSystem
	 */
	private static $_fileSystem = null;

    /**
     * @return Database
     */
    public static function GetDatabase()
    {
        require_once(ROOT_DIR . 'lib/Database/namespace.php');

        if (self::$_database == null)
        {
            self::$_database = DatabaseFactory::GetDatabase();
        }
        return self::$_database;
    }

    public static function SetDatabase(Database $database)
    {
        self::$_database = $database;
    }

    /**
     * @return Server
     */
    public static function GetServer()
    {
        require_once(ROOT_DIR . 'lib/Server/namespace.php');

        if (self::$_server == null)
        {
            self::$_server = new Server();
        }
        return self::$_server;
    }

    public static function SetServer(Server $server)
    {
        self::$_server = $server;
    }

	/**
	 * @static
	 * @return IEmailService
	 */
	public static function GetEmailService()
    {
        require_once(ROOT_DIR . 'lib/Email/namespace.php');

        if (self::$_emailService == null)
        {
            if (Configuration::Instance()->GetKey(ConfigKeys::ENABLE_EMAIL, new BooleanConverter()))
            {
                self::$_emailService = new EmailService();
//                self::$_emailService = new EmailLogger();
            }
            else
            {
                self::$_emailService = new NullEmailService();
            }
        }
        return self::$_emailService;
    }

    public static function SetEmailService(IEmailService $emailService)
    {
        self::$_emailService = $emailService;
    }

	/**
	 * @static
	 * @return \Booked\FileSystem
	 */
	public static function GetFileSystem()
	{
		require_once(ROOT_DIR . 'lib/FileSystem/namespace.php');

		if (self::$_fileSystem == null)
		{
			self::$_fileSystem = new \Booked\FileSystem();
		}

		return self::$_fileSystem;
	}

	public static function SetFileSystem(\Booked\IFileSystem $fileSystem)
	{
		self::$_fileSystem = $fileSystem;
	}

}
