<?php

<<<<<<< HEAD
require_once("Config.php");
=======
require_once "Config.php";
>>>>>>> 56354ac83421cc6b72ac4475dcfb6de824e62a5b

class MySQL{
    
    private $connection;

    public function __construct()
    {
        $this->connection = new \mysqli(HOST,USER,PASSWORD,DATABASE);
        $this->connection->set_charset("utf8");
    }

    public function execute($sql): bool
    {
        return $this->connection->query($sql);
    }
    
    public function query($sql): array
    {
        $result = $this->connection->query($sql);
        $item = array();
        $data = array();
        while($item = mysqli_fetch_array($result)){
            $data[] = $item;
        }
        return $data;
    }
}
