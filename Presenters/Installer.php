<?php

/**
 *
 */
class Installer {

    private $user;
    private $password;

    public function __construct($user, $password) {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * @param $should_create_db bool
     * @param $should_create_user bool
     * @param $should_create_sample_data bool
     * @return array|InstallationResult[]
     */
    public function InstallFresh($should_create_db, $should_create_user, $should_create_sample_data) {
        $results = array();

        $config = Configuration::Instance();

        $hostname = $config->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_HOSTSPEC);
        $database_name = $config->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_NAME);
        $database_user = $config->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_USER);
        $database_password = $config->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_PASSWORD);

        $create_database = new MySqlScript(ROOT_DIR . 'database_schema/create-db.sql');
        $create_database->Replace('phpscheduleit2', $database_name);

        $create_user = new MySqlScript(ROOT_DIR . 'database_schema/create-user.sql');
        $create_user->Replace('phpscheduleit2', $database_name);
        $create_user->Replace('schedule_user', $database_user);
        $create_user->Replace('localhost', $hostname);
        $create_user->Replace('password', $database_password);

        $create_schema = new MySqlScript(ROOT_DIR . 'database_schema/schema-utf8.sql');
        $populate_data = new MySqlScript(ROOT_DIR . 'database_schema/data-utf8.sql');
        $populate_sample_data = new MySqlScript(ROOT_DIR . 'database_schema/sample-data-utf8.sql');

        /**
         *
         */
        if ($should_create_db) {
            $results[] = $this->ExecuteScript($hostname, 'mysql', $this->user, $this->password, $create_database);
        }

        $results[] = $this->ExecuteScript($hostname, $database_name, $this->user, $this->password, $create_schema);

        /**
         *
         */
        if ($should_create_user) {
            $results[] = $this->ExecuteScript($hostname, $database_name, $this->user, $this->password, $create_user);
        }

        $results[] = $this->ExecuteScript($hostname, $database_name, $this->user, $this->password, $populate_data);

        /**
         *
         */
        if ($should_create_sample_data) {
            $results[] = $this->ExecuteScript($hostname, $database_name, $this->user, $this->password, $create_sample_date);
        }

        $results[] = $this->ExecuteScript($hostname, $database_name, $this->user, $this->password, $populate_sample_data);

        return $results;
    }

    public function ExecuteScript($hostname, $database_name, $db_user, $db_password, MySqlScript $script) {
        $result = new InstallationResult($script->Name());

        $sqlErrorCode = 0;
        $sqlErrorText = null;
        $sqlStmt = null;

        $link = mysql_connect($hostname, $db_user, $db_password);
        if (!$link) {
            $result->SetConnectionError();
            return $result;
        }

        $select_db_result = mysql_select_db($database_name, $link);
        if (!$select_db_result) {

            $result->SetAuthenticationError();
            return $result;
        }

        $sqlArray = explode(';', $script->GetFullSql());
        foreach ($sqlArray as $stmt) {
            if (strlen($stmt) > 3 && substr(ltrim($stmt), 0, 2) != '/*') {
                $queryResult = mysql_query($stmt);
                if (!$queryResult) {
                    $sqlErrorCode = mysql_errno();
                    $sqlErrorText = mysql_error();
                    $sqlStmt = $stmt;
                    break;
                }
            }
        }

        $result->SetResult($sqlErrorCode, $sqlErrorText, $sqlStmt);

        return $result;
    }

}
?>
