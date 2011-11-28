<?php

/**
 *
 */
class MySqlScript {

    /**
     * @var string
     */
    private $path;

    /**
     * @var array|string[]
     */
    private $tokens = array();

    public function __construct($path) {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function Name() {
        return $this->path;
    }

    public function Replace($search, $replace) {
        $this->tokens[$search] = $replace;
    }

    public function GetFullSql() {
        $f = fopen($this->path, "r");
        $sql = fread($f, filesize($this->path));
        fclose($f);

        foreach ($this->tokens as $search => $replace) {
            $sql = str_replace($search, $replace, $sql);
        }

        return $sql;
    }

}
?>
