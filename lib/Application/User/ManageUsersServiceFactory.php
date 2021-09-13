<?php

require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

interface IManageUsersServiceFactory
{
    /**
     * @return IManageUsersService
     */
    public function CreateAdmin();
}

class ManageUsersServiceFactory implements IManageUsersServiceFactory
{
    public function CreateAdmin()
    {
        $userRepository = new UserRepository();
        return new ManageUsersService(new AdminRegistration(), $userRepository, new GroupRepository(), $userRepository, new PasswordEncryption());
    }
}
