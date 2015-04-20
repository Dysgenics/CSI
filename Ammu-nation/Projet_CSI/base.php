<?php

/**
 * Permet la connexion à la base de données à partir d'un fichier .ini
 */
class Base {

    private static $dblink;

    public function __construct() {
        
    }

    /**
     * Effectue la connexion à la base
     * @return PDO
     */
    private static function connect() {
        //on récupère les informations dans le fichier .ini
        $config = parse_ini_file("config.ini");
        $dsn = $config['type'] . ':' . 'host=' . $config['host'] . ';dbname=' . $config['dbname'];

        try {
            //on se connecte à la base avec les informations contenues dans le fichier
            $db = new PDO($dsn, $config['user'], $config['pass'], array(PDO::ERRMODE_EXCEPTION => true,
                PDO::ATTR_PERSISTENT => true));
            $db->exec("SET CHARACTER SET utf8");
        } catch (PDOException $e) {
            //en cas d'erreur on affiche un message
            echo "connection: $dsn  " . $e->getMessage() . '<br/>';
        }
        return $db;
    }

    /**
     * Renvoit la connexion à la base
     * @return PDO
     */
    public static function getConnection() {

        //s'il la connexion a déjà été effectuée on la renvoit
        if (isset(self::$dblink)) {
            return self::$dblink;
        } else {
            //sinon on se connecte et on renvoit la connexion
            self::$dblink = self::connect();
            return self::$dblink;
        }
    }

}
?>