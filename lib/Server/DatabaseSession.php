<?php


/*
Revised code by Dominick Lee
Original code derived from "Run your own PDO PHP class" by Philip Brown
Last Modified 2/27/2017
*/

class DatabaseSessionConnection
{
    private $host;
    private $user;
    private $pass;
    private $dbname;
    private $dbh;
    private $error;
    private $stmt;

    public function __construct()
    {
        $this->host = Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_HOSTSPEC);
        $this->user = Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_USER);
        $this->pass = Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_PASSWORD);
        $this->dbname = Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_NAME);
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        }
        catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        return $this->stmt->execute();
    }

    public function resultset()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    public function beginTransaction()
    {
        return $this->dbh->beginTransaction();
    }

    public function endTransaction()
    {
        return $this->dbh->commit();
    }

    public function cancelTransaction()
    {
        return $this->dbh->rollBack();
    }

    public function debugDumpParams()
    {
        return $this->stmt->debugDumpParams();
    }

    public function close()
    {
        $this->dbh = null;
    }
}

/*
Revised code by Dominick Lee
Original code derived from "Essential PHP Security" by Chriss Shiflett
Last Modified 2/27/2017


CREATE TABLE sessions
(
    id varchar(32) NOT NULL,
    access int(10) unsigned,
    data text,
    PRIMARY KEY (id)
);

+--------+------------------+------+-----+---------+-------+
| Field  | Type             | Null | Key | Default | Extra |
+--------+------------------+------+-----+---------+-------+
| id     | varchar(32)      |      | PRI |         |       |
| access | int(10) unsigned | YES  |     | NULL    |       |
| data   | text             | YES  |     | NULL    |       |
+--------+------------------+------+-----+---------+-------+

*/

class DatabaseSession implements SessionHandlerInterface {
    private $db;

    public function __construct(){
        $this->db = new DatabaseSessionConnection();

        session_set_save_handler(
            array($this, "open"),
            array($this, "close"),
            array($this, "read"),
            array($this, "write"),
            array($this, "destroy"),
            array($this, "gc")
        );

        @session_start();
    }
    public function open($save_path, $name) {
        if($this->db){
            return true;
        }
        return false;
    }
    public function close(){
        if($this->db->close()){
            return true;
        }
        return false;
    }
    public function read($session_id){
        $this->db->query('SELECT data FROM sessions WHERE id = :id');
        $this->db->bind(':id', $session_id);
        if($this->db->execute()){
            $row = $this->db->single();
            return $row['data'];
        }else{
            return '';
        }
    }
    public function write($id, $data){
        $access = time();
        $this->db->query('REPLACE INTO sessions VALUES (:id, :access, :data)');
        $this->db->bind(':id', $id);
        $this->db->bind(':access', $access);
        $this->db->bind(':data', $data);
        if($this->db->execute()){
            return true;
        }
        return false;
    }
    public function destroy($session_id){
        $this->db->query('DELETE FROM sessions WHERE id = :id');
        $this->db->bind(':id', $session_id);
        if($this->db->execute()){
            return true;
        }
        return false;
    }
    public function gc($maxlifetime){
        $old = time() - $maxlifetime;
        $this->db->query('DELETE FROM sessions WHERE access < :old');
        $this->db->bind(':old', $old);
        if($this->db->execute()){
            return true;
        }
        return false;
    }
}