<?php

require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');
require_once(ROOT_DIR . 'lib/Database/MySQL/namespace.php');

class MoodleAdv extends Authentication implements IAuthentication
{
    /**
     * @var IAuthentication
     */
    private $authToDecorate;

    /**
     * @var IRegistration
     */
    private $_registration;

    /**
     * Needed to register user if they are logging in to Moodle but do not have a Booked Scheduler account yet
     */
    private function GetRegistration()
    {
        if ($this->_registration == null) {
            $this->_registration = new Registration();
        }

        return $this->_registration;
    }

    private $db;

    //
    private $retryDB;

    private $moodleDBHost;
    private $moodleDBName;
    private $moodleDBUser;
    private $moodleDBPass;
    private $moodlePrefix;

    private $authmethod;

    private $moodleRoles;

    private $moodleField;

    /**
     * @param IAuthentication $authentication Authentication class to decorate
     */
    public function __construct(IAuthentication $authentication)
    {
        $moodleadv_config_path = dirname(__FILE__) . '/MoodleAdv.config.php';
        require_once($moodleadv_config_path);

        $config = Configuration::Instance();
        $config->Register($moodleadv_config_path, 'MOODLEADV');

        $this->moodleDBHost = $config->File('MOODLEADV')->GetKey('moodleadv.dbhost');
        $this->moodleDBName = $config->File('MOODLEADV')->GetKey('moodleadv.dbname');
        $this->moodleDBUser = $config->File('MOODLEADV')->GetKey('moodleadv.dbuser');
        $this->moodleDBPass = $config->File('MOODLEADV')->GetKey('moodleadv.dbpass');
        $this->moodlePrefix = $config->File('MOODLEADV')->GetKey('moodleadv.prefix');


        $this->authmethod = $config->File('MOODLEADV')->GetKey('moodleadv.authmethod');

        switch ($this->authmethod) {
            case 'roles':
                $roles = $config->File('MOODLEADV')->GetKey('moodleadv.roles');
                $this->moodleRoles = $roles ? explode(',', $roles) : [];
                break;
            case 'field':
                $this->moodleField = $config->File('MOODLEADV')->GetKey('moodleadv.field');
                break;
        };

        $this->authToDecorate = $authentication;
    }

    /**
     * Called first to validate credentials
     * @see IAuthorization::Validate()
     */
    public function Validate($username, $password)
    {
        Log::Debug('MOODLEADV: Validating user');
        $account = $this->GetMoodleUser($username);
        if ($account && $this->user_check_password($password, $account)) {
            return true;
        };
        Log::Debug('MOODLEADV: User not found or wrong password');
        return false;
    }

    /**
     * Called after Validate returns true
     * @see IAuthorization::Login()
     */
    public function Login($username, $loginContext)
    {
        $account = $this->GetMoodleUser($username);
        $this->GetRegistration()->Synchronize(new AuthenticatedUser(
            $account->username,
            $account->email,
            $account->firstname,
            $account->lastname,
            '',
            Configuration::Instance()->GetKey(ConfigKeys::LANGUAGE),
            Configuration::Instance()->GetDefaultTimezone(),
            null,
            null,
            null
        ));
        $repo = new UserRepository();
        $user = $repo->LoadByUsername($username);
        $user->Deactivate();
        $user->Activate();
        $repo->Update($user);
        return $this->authToDecorate->Login($username, $loginContext);
    }

    /**
     * @see IAuthorization::Logout()
     */
    public function Logout(UserSession $user)
    {
        $this->authToDecorate->Logout($user);
    }

    /**
     * @see IAuthorization::AreCredentialsKnown()
     */
    public function AreCredentialsKnown()
    {
        return false;
    }

    /**
     * @param $username
     * @return mixed
     */
    private function GetMoodleUser($username)
    {
        // $db['port'] should be passed as a separate argument, per http://php.net/manual/mysqli.construct.php
        $moodleDb = new Database(new MySqlConnection($this->moodleDBUser, $this->moodleDBPass, $this->moodleDBHost, $this->moodleDBName));

        switch ($this->authmethod) {
            case 'roles':
                if ($m_roles = count($this->moodleRoles)) {
                    $query = 'SELECT u.* FROM '.$this->moodlePrefix.'user u JOIN '.$this->moodlePrefix.'role_assignments a ';
                    $query .= 'ON u.id=a.userid WHERE u.deleted=0 AND u.suspended=0 ';
                    $query .= 'AND u.username=@user AND a.roleid IN (';
                    $delimiter = '';
                    for ($i = 0; $i < $m_roles; $i++) {
                        $query .= $delimiter . '@role' . $i;
                        $delimiter = ', ';
                    }
                    $query .= ')';
                }
                $command = new AdHocCommand($query);
                $command->AddParameter(new Parameter('@user', $username));
                if ($m_roles) {
                    $rid = 0;
                    foreach ($this->moodleRoles as $role) {
                        $command->AddParameter(new Parameter('@role' . $rid++, $role));
                    }
                }
                break;
            case 'field':
                $query ='SELECT u.* FROM '.$this->moodlePrefix.'user u JOIN '.$this->moodlePrefix.'user_info_data a ';
                $query .= 'ON u.id=a.userid WHERE u.deleted=0 AND u.suspended=0 AND a.data=1 ';
                $query .= 'AND u.username=@user AND a.fieldid=@field';
                $command = new AdHocCommand($query);
                $command->AddParameter(new Parameter('@user', $username));
                $command->AddParameter(new Parameter('@field', $this->moodleField));
                break;
            case 'all':
                $query ='SELECT u.* FROM '.$this->moodlePrefix.'user u ';
                $query .= 'WHERE u.deleted=0 AND u.suspended=0 ';
                $query .= 'AND u.username=@user ';
                $command = new AdHocCommand($query);
                $command->AddParameter(new Parameter('@user', $username));
                break;
        }

        $reader = $moodleDb->Query($command);

        if ($row = $reader->GetRow()) {
            $account = new stdClass();
            foreach ($row as $k => $v) {
                $account->$k = $v;
            }
            return $account;
        }

        return false;
    }


    public function AllowUsernameChange()
    {
        return false;
    }

    public function AllowEmailAddressChange()
    {
        return false;
    }

    public function AllowPasswordChange()
    {
        return false;
    }

    public function AllowNameChange()
    {
        return false;
    }

    public function AllowPhoneChange()
    {
        return false;
    }

    public function AllowOrganizationChange()
    {
        return false;
    }

    public function AllowPositionChange()
    {
        return false;
    }


    public function user_check_password($password, $account)
    {
        return password_verify($password, $account->password);
    }
}
