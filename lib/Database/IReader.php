<?php

interface IReader
{
    /**
     * Returns the next row in the reader
     * @return array list of key-value pairs
     */
    public function GetRow();

    /**
     * @return int number of rows
     */
    public function NumRows();

    /**
     * Releases all rows held by the reader
     * @return void
     */
    public function Free();
}
