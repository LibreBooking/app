<?php
/**
* DBEngine class
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @author Richard Cantzler <rmcii@users.sourceforge.net>
* @version 08-08-06
* @package DBEngine
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

$basedir = dirname(__FILE__) . '/..';

include_once($basedir . '/lib/CmnFns.class.php');
/**
* Pear::DB
*/
if ($GLOBALS['conf']['app']['safeMode']) {
    ini_set('include_path', ( dirname(__FILE__) . '/pear/' . PATH_SEPARATOR . ini_get('include_path') ));
    include_once('pear/DB.php');
}
else {
    include_once('DB.php');
}

/**
* Provide all database access/manipulation functionality
*/
class DBEngine {

    var $db;                            // Reference to the database object
    var $dbs = array();                    // List of database names to use.  This will be used if more than one database is created and different tables are associated with multiple databases    
    var $table_to_database = array();    // Array associating tables to databases
    var $prefix;                        // Prefix to prepend to all primary keys
    
    var $err_msg = '';
    
    /**
    * DBEngine constructor to initialize object
    * @param none
    */
    function DBEngine() {
        $this->prefix = $GLOBALS['conf']['db']['pk_prefix'];
        $this->dbs = array ($GLOBALS['conf']['db']['dbName']);
        
        $this->db_connect();
        $this->define_tables();
    }
    
    /**
    * Create a persistent connection to the database
    * @param none
    * @global $conf
    */
    function db_connect() {
        global $conf;
    
        /***********************************************************
        / This uses PEAR::DB
        / See http://www.pear.php.net/manual/en/package.database.php#package.database.db
        / for more information and syntax on PEAR::DB
        /**********************************************************/
    
        // Data Source Name: This is the universal connection string
        // See http://www.pear.php.net/manual/en/package.database.php#package.database.db
        // for more information on DSN
        $dsn = $conf['db']['dbType'] . '://' . $conf['db']['dbUser'] . ':' . $conf['db']['dbPass'] . '@' . $conf['db']['hostSpec'] . '/' . $this->dbs[0];

        // Make persistant connection to database
        $db = DB::connect($dsn, true);
		@$db->setOption('portability', DB_PORTABILITY_ALL);
    
        // If there is an error, print to browser, print to logfile and kill app
        if (DB::isError($db)) {
            die ('Error connecting to database: ' . $db->getMessage() );
        }
        
        // Set fetch mode to return associatve array
        $db->setFetchMode(DB_FETCHMODE_ASSOC);
    
        $this->db = $db;
    }
    
    /////////////////////////////////////////////////////
    // Common functions
    /////////////////////////////////////////////////////
    /**
    * Defines the $table_to_database array
    * This array will relate each table to a database name,
    *  making it very easy to change all table associations
    *  if additional databases are added
    * @param none
    */
    function define_tables() {
        $this->table_to_database = array (
                        'login'         => $this->dbs[0],
                        'reservations'    => $this->dbs[0],
                        'resources'        => $this->dbs[0],
                        'permission'    => $this->dbs[0],
                        'schedules'        => $this->dbs[0],
                        'schedule_permission' => $this->dbs[0]
                                                        );
                        
    }
    
    /**
    * Returns the database and table name in form: database.table
    * @param string $table table to return
    * @global $conf
    * @return fully qualified table name in form: database.table
    */
    function get_table($table) {
        global $conf;
        return $conf['db']['tbl_prefix'] . $table;
        //return $this->table_to_database[$table] . '.' . $table;
    }
    
    /**
    * Assigns a table to a database for SQL statements
    * @param string $table name of table to change
    * @param strin $database name of database that this table belongs to
    * @return success of assignment
    */
    function set_table($table, $database) {
        if (!isset($this->table_to_database[$table]))
            return false;
        else
            $this->table_to_database[$table] = $database;
        return true;
    }
    
    /**
    * Generic database query function.
    * This will return specified fields from one table in a specified order
    * @param string $table name of table to return from
    * @param array $fields array of field values to return
    * @param string $order sql order string
    * @param int $limit limit of query
    * @param int $offset offset of limit
    * @return mixed all data found in query
    */
    function get_table_data($table, $fields = array('*'), $orders = array(), $limit = NULL, $offset = NULL, $where_clause = NULL, $where_values = array()) {
        $return = array();

        $order = CmnFns::get_value_order($orders);        // Get main order value    
        $vert = CmnFns::get_vert_order();                // Get vertical order
        
        $query = 'SELECT ' . join(', ', $fields)
            . ' FROM ' . $this->get_table($table)
            . ' ' . $where_clause . ' '
            . (!empty($order) ? " ORDER BY $order $vert" : '');        
        
        // Append any other sorting constraints    
        for ($i = 1; $i < count($orders); $i++)
            $query .= ', ' . $orders[$i];
        
        if (!is_null($limit) && !is_null($offset))        // Limit query
            $result = $this->db->limitQuery($query, $offset, $limit, $where_values);
        else                                        // Standard query
            $result = $this->db->query($query, $where_values);
        
        $this->check_for_error($result);
        
        if ($result->numRows() <= 0) {        // Check if any records exist
            $this->err_msg = translate('There are no records in the table.', array($table));
            return false;
        }
        
        while ($rs = $result->fetchRow())
            $return[] = $this->cleanRow($rs);
        
        $result->free();
        
        return $return;
    }
    
    /**
    * Deletes a list of rows from the database
    * @param string $table table name to delete rows from
    * @param string $field field name that items are in
    * @param array $to_delete array of items to delete
    */
    function deleteRecords($table, $field, $to_delete) {
        // Put into string, quoting each value
        $delete = join('","', $to_delete);
        $delete = '"'. $delete . '"';
        
        $result = $this->db->query('DELETE FROM ' . $this->get_table($table) . ' WHERE ' . $field . ' IN (' . $delete . ')');
        
        $this->check_for_error($result);        // Check for an error
        
        return true;
    }        

    
    /**
    * Return all reservations associated with a user
    * @param string $id user id
    * @param string $order the order for the return results
    * @param string $vert the vertical sorting order
    * @param bool $include_participating if this should include the reservations where the user is only particpating
    * @return array of reservation data
    */
    function get_user_reservations($id, $order, $vert, $include_participating = false) {
        $return = array();
		
		// Clean out the duplicated order so that MSSQL is OK
		$orders = trim(preg_replace("/(res|rs).$order,?/", '', 'res.start_date, rs.name, res.starttime'));
		if (strrpos($orders, ',') == strlen($orders)-1) {
			$orders = substr($orders, 0, strlen($orders)-1);
		}
        
		$query = 'SELECT res.*, resusers.*, rs.name, rs.location, rs.rphone FROM '
                    . $this->get_table('reservations') . ' as res INNER JOIN '
                    . $this->get_table('resources') . ' as rs ON rs.machid=res.machid INNER JOIN '
                    . $this->get_table('reservation_users') . ' as resusers ON resusers.resid=res.resid'
                    . ' WHERE resusers.memberid=?'
                    . ' AND (res.start_date>=? OR (res.start_date<=? AND res.end_date>=?))'
                    . ' AND res.is_blackout <> 1'
                    . (!$include_participating ? ' AND owner = 1' : ' AND invited = 0')
                    . " ORDER BY $order $vert, res.start_date, rs.name, res.starttime";
  
        $values = array($id, mktime(0,0,0), mktime(0,0,0), mktime(0,0,0));

        // Prepare query
        $q = $this->db->prepare($query);
        // Execute query
        $result = $this->db->execute($q, $values);
        // Check if error
        $this->check_for_error($result);
        
        if ($result->numRows() <= 0) {
            $this->err_msg = translate('You do not have any reservations scheduled.');
            return false;
        }
        
        while ($rs = $result->fetchRow()) {
            $return[] = $this->cleanRow($rs);
        }
        
        $result->free();
        
        return $return;
    }
    

    /**
    * Gets all the resources that the user has permission to reserve
    * @param string $userid user id
    * @return array or resource data
    */
    function get_user_permissions($userid) {
        $return = array();
        
        $sql = 'SELECT rs.* FROM '
                    . $this->get_table('permission') . ' as pm INNER JOIN '
                    . $this->get_table('resources') . ' as rs ON pm.machid=rs.machid'
                    . ' WHERE pm.memberid=?'
                    . ' ORDER BY rs.name';
                    
        // Execute query
        $result = $this->db->query($sql, array($userid));
        // Check if error
        $this->check_for_error($result);
        
        if ($result->numRows() <= 0) {
            $this->err_msg = translate('You do not have permission to use any resources.');
            return false;
        }

        while ($rs = $result->fetchRow()) {
            $return[] = $this->cleanRow($rs);
        }
        
        $result->free();
        
        return $return;
    }
    
    /**
    * Get associative array with machID, resource name, and status
    * This function loops through all resources
    *  and constructs an associative array with the
    *  resource's machID, name and status as
    *  $array[x] => ('machid' => 'this_resource_id', 'name' => 'Resource Name', 'status' => 'a')
    * @param none
    * @return array of machID, resource name, status
    */
    function get_mach_ids($scheduleid = null) {
        $return = array();
        $values = array();
        
        $sql = 'SELECT machid, name, status, approval, min_notice_time, max_notice_time FROM ' . $this->get_table('resources');
        if ($scheduleid != null) {
            $sql .= ' WHERE scheduleid = ?';
            $values = array($scheduleid);
        }
        $sql .= ' ORDER BY name';
        
        $result = $this->db->query($sql, $values);
        
        $this->check_for_error($result);
        
        if ($result->numRows() <= 0) {
            $this->err_msg = translate('No resources in the database.');
            return false;
        }        

        while ($rs = $result->fetchRow()) {
            $return[] = $this->cleanRow($rs);
        }
        
        $result->free();
        
        return $return;
    }
    
    /**
    * Gets the default scheduleid
    * @param none
    * @return string scheduleid of default schedule
    */
    function get_default_id() {
        $result = $this->db->getOne('SELECT scheduleid FROM ' . $this->get_table('schedules') . ' WHERE isdefault = 1 AND ishidden = 0');
        $this->check_for_error($result);

        if (empty($result)) {    // If default is hidden
            $result = $this->db->getOne('SELECT scheduleid FROM ' . $this->get_table('schedules') . ' WHERE ishidden = 0');
            $this->check_for_error($result);
        }

        return $result;
    }
    
    /**
    * Checks to see if the scheduleid is valid
    * @param none
    * @return whether it is valid or not
    */
    function check_scheduleid($scheduleid) {
        $result = $this->db->getOne('SELECT COUNT(scheduleid) AS num FROM ' . $this->get_table('schedules') . ' WHERE scheduleid = ? AND ishidden <> 1', array($scheduleid));
        $this->check_for_error($result);

        return (intval($result) > 0);
    }
    
        
    /**
    * Gets all data for a given schedule
    * @param string $scheduleid id of schedule
    * @param array of schedule data
    */
    function get_schedule_data($scheduleid) {
        $result = $this->db->getRow('SELECT * FROM ' . $this->get_table('schedules') . ' WHERE scheduleid = ?', array($scheduleid));
        $this->check_for_error($result);
        
        return $result;
    }
    
    /**
    * Gets the list of available schedules
    * @param none
    */
    function get_schedule_list() {
        $return = array();
        
        $result = $this->db->query('SELECT scheduleid, scheduletitle FROM ' . $this->get_table('schedules') . ' WHERE ishidden = 0 ORDER BY scheduletitle');
        $this->check_for_error($result);
        
        while ($rs = $result->fetchRow())
            $return[] = $this->cleanRow($rs);
        
        return $return;
    }
    
    /**
    * Return all announcements
    * @param string $order sort order
    * @param int $datetime the current datetime so we can only get the announcements that we should see
    * @return array of announcements
    */
    function get_announcements($datetime) {
        $return = array();
        
        $query = 'SELECT announcement FROM '
                    . $this->get_table('announcements')
                    . ' WHERE (start_datetime <= ? AND end_datetime >= ?)'
                    . ' OR (start_datetime IS NULL AND end_datetime >= ?)'
                    . ' OR (start_datetime <= ? AND end_datetime IS NULL)'
                    . ' OR (start_datetime IS NULL AND end_datetime IS NULL)'
                    . " ORDER BY number";
    
        // Prepare query
        $q = $this->db->prepare($query);
        // Execute query
        $result = $this->db->execute($q, array($datetime, $datetime, $datetime, $datetime));
        // Check if error
        $this->check_for_error($result);
        
        if ($result->numRows() <= 0) {
            $this->err_msg = 'There are no announcements.';
            return false;
        }
        
        while ($rs = $result->fetchRow()) {
            $return[] = $this->cleanRow($rs);
        }
        
        $result->free();
        
        return $return;
    }
    
    /**
    * Return all reservations that the user has been invited to or accepted (where they are not the owner)
    * @param string $id user id
    * @param bool $invited_only if we should get only the reservations which the user has been invited and not responded to yet
    * @return array of reservation data
    */
    function get_user_invitations($id, $invited_only = true) {
        $return = array();
        
        $invited = ($invited_only) ? '1' : '0';
        
        $query = "SELECT ru.resid, ru.memberid, ru.accept_code, l.fname, l.lname, r.start_date, r.end_date, r.starttime, r.endtime, res.name FROM " . $this->get_table('reservation_users') . " AS ru
                    LEFT JOIN " . $this->get_table('reservations') . " AS r ON ru.resid = r.resid
                    LEFT JOIN " . $this->get_table('resources') . " AS res ON res.machid=r.machid
                    LEFT JOIN " . $this->get_table('reservation_users') . " AS ru2 ON ru.resid=ru2.resid
                    LEFT JOIN " . $this->get_table('login') . " AS l ON l.memberid = ru2.memberid
                    WHERE ru.memberid=?
                    AND (r.start_date>=? OR (r.start_date<=? AND r.end_date>=?))
                    AND ru2.owner=1
                    AND r.is_blackout <> 1
                    AND r.is_pending <> 1
                    AND ru.invited = $invited
                    AND ru.memberid <> ru2.memberid
                    ORDER BY r.start_date, res.name, r.starttime";
        $values = array($id, mktime(0,0,0), mktime(0,0,0), mktime(0,0,0));
        
        // Prepare query
        $q = $this->db->prepare($query);
        // Execute query
        $result = $this->db->execute($q, $values);
        // Check if error
        $this->check_for_error($result);
        
        if ($result->numRows() <= 0) {
            $this->err_msg = translate('You do not have any reservations scheduled.');
            return false;
        }
        
        while ($rs = $result->fetchRow()) {
            $return[] = $this->cleanRow($rs);
        }
        
        $result->free();
        
        return $return;
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    /**
    * Checks to see if there was a database error and die if there was
    * @param object $result result object of query
    */
    function check_for_error($result) {
        if (DB::isError($result))
            CmnFns::do_error_box(translate('There was an error executing your query') . '<br />'
                . $result->getMessage()
                . '<br />' . '<a href="javascript: history.back();">' . translate('Back') . '</a>');
        return false;
    }
    
    /**
    * Generates a new random id for primary keys
    * @param string $prefix string to prefix to id
    * @return random id string
    */
    function get_new_id($prefix = '') {
        // Use the passed in prefix, if it exists
        if (!empty($prefix))
            $this->prefix = $prefix;
        
        // Only use first 3 letters
        $this->prefix = strlen($this->prefix) > 3 ? substr($this->prefix, 0, 3) : $this->prefix;
        
        return uniqid($this->prefix);
    }
    
    /**
    * Enodes a string into an encrypted password string
    * @param string $pass password to encrypt
    * @return encrypted password
    */
    function make_password($pass) {
        return md5($pass);
    }
    
    /**
    * Strips out slashes for all data in the return row
    * - THIS MUST ONLY BE ONE ROW OF DATA -
    * @param array $data array of data to clean up
    * @return array with same key => value pairs (except slashes)
    */
    function cleanRow($data) {
        $return = array();
            
        foreach ($data as $key => $val)
            $return[$key] = stripslashes($val);
        return $return;
    }
    
    /**
    * Makes an array of ids in to a comma seperated string of values
    * @param array $data array of data to convert
    * @return string version of the array
    */
    function make_del_list($data) {
        $c = join('\',\'', $data);
        return "'" . $c . "'";
    }
	
	/**
    * Makes an array of ids in to a comma seperated string of values
    * @param array $data array of data to convert
    * @return string version of the array
    */
	function make_in_list($data) {
		return $this->make_del_list($data);
	}
    
    /**
    * Returns the last database error message
    * @param none
    * @return last error message generated
    */
    function get_err() {
        return $this->err_msg;
    }
}
?>