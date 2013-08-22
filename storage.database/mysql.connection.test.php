<?php

// Boot
require_once dirname(dirname(dirname(__FILE__))).'/src/attitude/autoload.php';
use \attitude\Implementations\DependencyInjection\DependencyContainer as DependencyContainer;

class MySQLConnection extends \attitude\Abstracts\Storage\DatabaseConnection
{
    public function __construct()
    {
        return parent::__construct();
    }
}

class MySQLConnectionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException       Exception
     * @expectedExceptionCode   1045
     */
    public function testBadUser()
    {
        DependencyContainer::set('MySQLConnection::$dsn', 'mysql:dbname=test_database_connection;host=127.0.0.1');
        DependencyContainer::set('MySQLConnection::$username', 'badusername');
        DependencyContainer::set('MySQLConnection::$password', 'root');

        $dbconnection = new MySQLConnection;
    }


    /**
     * @expectedException       Exception
     * @expectedExceptionCode   1045
     */
    public function testBadPswd()
    {
        DependencyContainer::set('MySQLConnection::$dsn', 'mysql:dbname=test_database_connection;host=127.0.0.1');
        DependencyContainer::set('MySQLConnection::$username', 'root');
        DependencyContainer::set('MySQLConnection::$password', 'wrongpassword');

        $dbconnection = new MySQLConnection;
    }

    public function testInit()
    {
        DependencyContainer::set('MySQLConnection::$dsn', 'mysql:dbname=test_database_connection;host=127.0.0.1');
        DependencyContainer::set('MySQLConnection::$username', 'root');
        DependencyContainer::set('MySQLConnection::$password', 'root');

        $dbconnection = new MySQLConnection;

        return true;
    }

    /**
     * @depends testInit
     */
    public function testInitUserTable()
    {

    }
}
