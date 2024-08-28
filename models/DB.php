<?php
class DB extends PDO
{
    public function __construct()
    {
        $dsn = "mysql:host=localhost;dbname=aeropuerto";
        parent::__construct($dsn, "root", "");
    }
}
