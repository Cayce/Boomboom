<?php

/*
 * Author - Chudinov Kirill
 */

set_error_handler('log::php_error_handler');
set_exception_handler('log::php_exception_handler');

class log
{
    /** Gets an php error message and writes it to the database
     *
     * @param integer $errno
     * @param string  $errstr
     * @param string  $file
     * @param integer $errline
     * @param link    $data 
     */
    public static function php_error_handler($errno, $errstr, $file, $errline, $data)
    {
        try
        {
            
                // Connecting to database
            $dsn = DBMS_NAME.':dbname='.DB_DATABASENAME.';host='.DB_HOST.';port='.DB_PORT;
            $dbh = new PDO($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $errorType = array ('ERROR', 'WARNING', 'PARSING ERROR', 'NOTICE', 'CORE ERROR', 'CORE WARNING', 'COMPILE ERROR', 'COMPILE WARNING', 'USER ERROR', 'USER WARNING', 'USER NOTICE','STRICT NOTICE','RECOVERABLE ERROR');
            $errorType = isset($errorType[$errno])?$errorType[$errno]:$errno;
            $message   = $dbh->quote("$errorType on line $errline: $errstr");
            $type      = "'PHP'";
            $file      = $dbh->quote($file);
            $data      = $dbh->quote(print_r($data,1));

                // If already there are this error, just remembering it happened again
            $query = $dbh->query("SELECT `id_record`,`num_cases` FROM `".DB_DATABASENAME_LOG."`.`log` WHERE `project`=".$dbh->quote(PR_NAME)." AND `file`=$file AND `type`=$type AND `message`=$message");
            if($p = $query->fetch())
            {
                $id_record = $p['id_record'];
                $num_cases = $p['num_cases'];
                $dbh->query("UPDATE `".DB_DATABASENAME_LOG."`.`log` SET `num_cases`=".($num_cases+1)." WHERE `id_record`=$id_record");
            }
                // Else writting this error to database
            else
            {
                $dbh->query("INSERT INTO `".DB_DATABASENAME_LOG."`.`log`(`project`,`file`,`type`,`message`,`data`,`date`) VALUES(".$dbh->quote(PR_NAME).", $file,$type,$message,$data,NOW())");
                $id = $dbh->lastInsertId();
            }

                // If project in live mode, not printing error, but only it id
            if(PR_MODE===1)
                echo 'There are unexpected error, id error: '.$id_record;
            else
                echo 'Error('.$type.') in file '.$file.': '.$message;

            die;
        }
        
        catch (PDOException $e)
        {
                // If project in live mode, not printing error
            if(PR_MODE===1)
                die('Houston, we have a problem!');
            else
                die($e->getMessage());
        }
    }
    
    public static function php_exception_handler($exception)
    {
        try
        {
                // Connecting to database
            $dsn = DBMS_NAME.':dbname='.DB_DATABASENAME.';host='.DB_HOST.';port='.DB_PORT;
            $dbh = new PDO($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $file      = $dbh->quote($exception->getFile());
            $type      = "'Exception'";
            $message   = 'Exception on line '.$exception->getLine().': '.$exception->getMessage();
            $message   = $dbh->quote($message);
            $data      = $dbh->quote(print_r($exception,1));

                // If already there are this error, just remembering it happened again
            $query = $dbh->query("SELECT `id_record`,`num_cases` FROM `".DB_DATABASENAME_LOG."`.`log` WHERE `project`=".$dbh->quote(PR_NAME)." AND `file`=$file AND `type`=$type AND `message`=$message");
            if($p = $query->fetch())
            {

                $id_record = $p['id_record'];
                $num_cases = $p['num_cases'];
                $dbh->query("UPDATE `".DB_DATABASENAME_LOG."`.`log` SET `num_cases`=".($num_cases+1)." WHERE `id_record`=$id_record");
            }
                // Else writting this error/log-record to database
            else
            {
                $query = $dbh->query("INSERT INTO `".DB_DATABASENAME_LOG."`.`log`(`project`,`file`,`type`,`message`,`data`,`date`) VALUES(".$dbh->quote(PR_NAME).", $file,$type,$message,$data,NOW())");
                $id = $dbh->lastInsertId();
            }

                // If project in live mode, not printing error, but only it id
            if(PR_MODE===1)
                echo 'There are unexpected error, id error: '.$id_record;
            else
                echo 'Error('.$type.') in file '.$file.': '.$message;

            die; 
        }
        
        catch (PDOException $e)
        {
                // If project in live mode, not printing error
            if(PR_MODE===1)
                die('Houston, we have a problem!');
            else
                die($e->getMessage());
        }
    }


}

