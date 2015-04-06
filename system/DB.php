<?php 

class DB extends FluentPDO
{
    public function __construct()
    {
        $db_file = '../storage.sqlite3';
        if(!file_exists($db_file))
            touch($db_file);

        $pdo = new PDO("sqlite:" . $db_file);
        parent::__construct($pdo);
    }
}