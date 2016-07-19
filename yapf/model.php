<?php
namespace yapf;

use PDO;
use PDOException;

class DatabaseConnectionException extends \Exception
{
}

class model
{
    protected function getDatabaseConnection($connection_name = 'default')
    {
        $data = parse_ini_file(app_config . 'database.ini.php', true);
        if (isset($data[$connection_name])) {
            $connection = $data[$connection_name];
            try {
                $db = new PDO($connection['dsn'], $connection['user'], $connection['password']);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                throw new DatabaseConnectionException('cannot connect to the database. PDO msg: ' . $e->getMessage(), $e->getCode(), $e);
            }
            return $db;
        } else {
            throw new DatabaseConnectionException("[$connection_name] does not exists as an connection string. Check configuration file 'database.ini.php'");
        }
    }
}