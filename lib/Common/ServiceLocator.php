<?php
/**
Copyright 2011-2012 Nick Korbel

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
    private static $_emailSerivce = null;

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
     * Returning a server object
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

    public static function GetEmailService()
    {
        require_once(ROOT_DIR . 'lib/Email/namespace.php');

        if (self::$_emailSerivce == null)
        {
            if (Configuration::Instance()->GetKey(ConfigKeys::ENABLE_EMAIL, new BooleanConverter()))
            {
                self::$_emailSerivce = new EmailService();
//                self::$_emailSerivce = new EmailLogger();
            }
            else
            {
                self::$_emailSerivce = new NullEmailService();
            }
        }
        return self::$_emailSerivce;
    }

    public static function SetEmailService(IEmailService $emailService)
    {
        self::$_emailSerivce = $emailService;
    }

}

?>