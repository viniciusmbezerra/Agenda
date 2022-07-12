<?php

namespace App;

class Connection {
	private static $conn;

	public static function getDb() {

		$host = '127.0.0.1';
		$port = '3306';
		$name = 'agenda';
		$user = 'root';
		$pass = '81442420';

		try {
			$conn = new \PDO("mysql:host={$host};port={$port};dbname={$name}","{$user}","{$pass}");

			return $conn;

		} catch (\PDOException $e) {
			//.. tratar de alguma forma ..//
		}
	}

	public static function getConnection()
    {
        if (empty(self::$conn))
        {
            $ini = parse_ini_file('config/agenda.ini');
            $host = $ini['host'];
            $port = $ini['port'];
            $name = $ini['name'];
            $user = $ini['user'];
            $pass = $ini['pass'];

            self::$conn = new \PDO("mysql:host={$host};
									port={$port};
									dbname={$name}","{$user}","{$pass}");
            self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }

	public static function getConnectionMysqli() {
		
		if (empty(self::$conn)) {

			self::$conn = mysqli_connect('127.0.0.1', 'root', '81442420', 'agenda');

		}

		return self::$conn;
	}
}

?>