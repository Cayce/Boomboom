<?php

/*
 * Author - Chudinov Kirill
 */

class db
{
    private $DBMS       = DBMS_NAME;        // Database management system name, usually mysql
    private $HOST       = DB_HOST;          // Host of the database, usually 127.0.0.1
    private $PORT       = DB_PORT;          // Port for connection to database, usually 3306
    private $USER       = DB_USER;          // User of the databse
    private $PASS       = DB_PASS;          // Password of the user
    private $db_default = DB_DATABASENAME;  // Name of the database that script will connect by default

    private static $connection; // A link to dabase connection
       

    /** A private constructor; prevents direct creation of object
     *
     * @param string $db 
     */
    private function __construct()
    {
            // Connecting to database, and restore link in self::$connection
        $dsn = $this->DBMS.':dbname='.$this->db_default.';host='.$this->HOST.';port='.$this->PORT;
        
        try
        {
            self::$connection = new PDO($dsn, $this->USER, $this->PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            die('Connection to database failed :(');
        }  

    }

    /**  The singleton method
     *
     * @param string $db
     * @return link 
     */
    public static function connect($db=DB_DATABASENAME)
    {
            // If there are no connectin, we connect to database 
        if (!isset(self::$connection))
            new db();
    }

    /** Query to database
     *
     * @param string $query
     * @return link 
     */
    public static function query($query)
    {
        return $query = self::$connection->query($query);
    }
    
    /** Quotes a string for use in a query. 
     *
     * @param string $query
     * @return link 
     */
    public static function quote($string)
    {
        return self::$connection->quote($string);
    }
    
    /** Return id that command INSERT created
     *
     * @return link 
     */
    public static function lastInsertId()
    {
        return self::$connection->lastInsertId();
    }

        // Prevent users to clone the instance
    private function __clone()
    {
    }
}