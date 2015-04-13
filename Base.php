<?php

class Base {
	
	public static function getConnection(){
		try {
			$dsn="mysql:host=sql.free.fr;dbname=kilian.cuny";
			$db = new PDO($dsn, 'kilian_cuny','ohfoowev',
			array(PDO::ERRMODE_EXCEPTION=>true,
			PDO::ATTR_PERSISTENT=>true));
			$db->exec('SET NAMES utf8');
		} catch(PDOException $e) {
			throw new BaseException("connection: $dsn ".$e->getMessage(). '<br/>');
		}
		return $db;
	}

}