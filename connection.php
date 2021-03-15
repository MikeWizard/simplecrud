<?php
define("SERVER", "localhost"); 
define("USER", ""); 
define("PASSWORD", ""); 
define("DATABASE", "simplecrud"); 

class Database extends MySQLi {
  private static $instance = null ;

  private function __construct(string $host,string $user,string $password,string $database){ 
      parent::__construct($host, $user, $password, $database);
  }

  public static function getInstance(){
      if (self::$instance == null){
          self::$instance = new self(SERVER, USER, PASSWORD, DATABASE);
      }
      return self::$instance ;
  }
}
?>
