<?php

interface IDbConnection
{
    public function Connect();
    public function Disconnect();

    /**
     * Queries the database and returns an IReader
     *
     * @param ISqlCommand $command
     * @return IReader to iterate over
     */
    public function Query(ISqlCommand $command);

    /**
     * @param ISqlCommand $command
     * @param int $limit
     * @param int $offset
     * @return IReader to iterate over
     */
    public function LimitQuery(ISqlCommand $command, $limit, $offset = null);

    /**
     * Executes an alter query against the database
     *
     * @param ISqlCommand $command
     * @return void
     */
    public function Execute(ISqlCommand $command);

    /**
     * @return int last auto-increment id inserted for this connection
     */
    public function GetLastInsertId();
}
