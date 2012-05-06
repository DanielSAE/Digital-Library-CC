<?php

class Database
  {
    private static $db; 
 
	static public function getInstance() { 
		if(!self::$db) { 
			self::$db = new PDO( 
				'mysql:host='.DB_HOST.';dbname='.DB_DATABASE.';port='.DB_PORT, 
				DB_USER, 
				DB_PASSWORD, 
				array( 
					PDO::ATTR_PERSISTENT => true, 
					#PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ,
					PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
				) 
			);
		self::$db->query('SET NAMES utf8'); //Zeichensatz uft8
		} 
		return self::$db; 
	} 
}
?>