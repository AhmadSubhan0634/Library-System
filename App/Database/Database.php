<?php

namespace App\Database;

use PDO;
use PDOException;

class Database {
    private string $host;
    private string $databasename;
    private string $username;
    private string $password;
    private static ?PDO $connection=null;

    public function __construct(
        string $host='127.0.0.1',
        string $dbname='Library_System',
        string $user='root',
        string $pass='F240634@lhr.nu'
    ){
        $this->host=$host;
        $this->databasename=$dbname;
        $this->username=$user;
        $this->password=$pass;
    }
    
    public function getConnection():PDO{
        if(self::$connection===NULL){
            $datasourcename="mysql:host={$this->host};dbname={$this->databasename};charset=utf8mb4";

            try{
                self::$connection=new PDO($datasourcename,$this->username,$this->password,
                [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES=>false,]);           
            }
            catch(PDOException $e){
                throw new PDOException("Database connection failed" .$e->getMessage());
            }
        }
        return self::$connection;
    }
}
?>