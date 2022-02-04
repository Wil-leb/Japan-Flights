<?php

namespace App\core;

//*****GOAL: TO CONNECT TO THE DATABASE, IN ORDER TO COMMUNICATE WITH IT*****//
//***************************************************************************//

//*****METHODS: TO DECLARE THE CONNECTION INFORMATION AND TO CONTROL THE CONNECTION********//

use \PDO;

class Connect {
    
//*****1. Declaring the connection information*****//
    const HOST = "db.3wa.io";
    const DB_NAME ="wilfridleb_flights";
    const USER ="wilfridleb";
    const PASSWORD = "a79d0ca0b9a30b6f484ffde6adf777db";
    

//*****2. Controlling the connection*****//
    public function connection() {
        $pdo = new PDO('mysql:host='.self::HOST.';dbname='.self::DB_NAME, self::USER, self::PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET NAMES UTF8');
        return $pdo;
        
//*****END OF THE connection() METHOD*****//
    }

//*****END OF THE Connect CLASS*****//
}
