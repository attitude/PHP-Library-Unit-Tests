<?php

// Boot
require_once dirname(dirname(dirname(__FILE__))).'/src/attitude/autoload.php';
use \attitude\Implementations\DependencyInjection\DependencyContainer as DependencyContainer;

class UsersMySQLConnection extends \attitude\Abstracts\Storage\DatabaseConnection
{
    public function __construct()
    {
        return parent::__construct();
    }
}

class UsersDBDocumentStorage extends \attitude\Abstracts\Storage\DatabaseStorage\TableStorage\DocumentStorage
{
    public function __construct()
    {
        return parent::__construct();
    }

    public function unsetup()
    {
        return parent::unsetup();
    }

    public function truncate()
    {
        return parent::truncate();
    }
}

class UsersDBDocumentStorageTest extends PHPUnit_Framework_TestCase
{
    static $dbconnection;
    static $user_table_storage;
    static $record_id;

    public function testInit()
    {
        DependencyContainer::set('UsersMySQLConnection::$dsn', 'mysql:dbname=test_database_connection;host=127.0.0.1');
        DependencyContainer::set('UsersMySQLConnection::$username', 'root');
        DependencyContainer::set('UsersMySQLConnection::$password', 'root');

        static::$dbconnection = new UsersMySQLConnection;

        return true;
    }

    /**
     * @depends testInit
     */
    public function testInitUserTable()
    {
        DependencyContainer::set('UsersDBDocumentStorage::$database_engine', static::$dbconnection);
        DependencyContainer::set('UsersDBDocumentStorage::$data_serializer', '\attitude\Implementations\Data\JSONSerializer');
        DependencyContainer::set('UsersDBDocumentStorage::$table_name', 'users_'.time());

        DependencyContainer::set('UsersDBDocumentStorage::$primary_key', '\attitude\Implementations\Storage\Column\DocumentStorage\IDColumn');
        DependencyContainer::set('UsersDBDocumentStorage::$updated_column', '\attitude\Implementations\Storage\Column\DocumentStorage\CreatedColumn');
        DependencyContainer::set('UsersDBDocumentStorage::$created_column', '\attitude\Implementations\Storage\Column\DocumentStorage\UpdatedColumn');
        DependencyContainer::set('UsersDBDocumentStorage::$body_column', '\attitude\Implementations\Storage\Column\DocumentStorage\BodyColumn');

        static::$user_table_storage = new UsersDBDocumentStorage;
        $this->assertNotNull(static::$user_table_storage);

        return true;
    }

    /**
     * @depends testInitUserTable
     */
    public function testFillWithData()
    {
        $this->assertTrue(!! static::$user_table_storage->store(array(
            'first_name' => 'Martin',
            'last_name'  => 'Adamko',
            'user_name'  => 'martin_adamko'
        )));

        $this->assertTrue(!! static::$user_table_storage->store(array(
            'first_name' => 'Milan',
            'last_name'  => 'Lasica',
            'user_name'  => 'milan_lasica'
        )));

        static::$record_id = static::$user_table_storage->store(array(
            'first_name' => 'Ján',
            'last_name'  => 'Króner',
            'user_name'  => 'jan_kroner'
        ));

        $this->assertTrue(!! static::$record_id);
    }

    /**
     * @depends testFillWithData
     */
    public function testUserEdit()
    {
        $data = static::$user_table_storage->get(static::$record_id);

        $this->assertArrayHasKey('first_name', $data);
        $this->assertArrayHasKey('last_name', $data);
        $this->assertArrayHasKey('user_name', $data);

        $data['first_name'] = 'Janko';
        $data['user_name']  = 'janko_kroner';

        $this->assertTrue(!! static::$user_table_storage->set(static::$record_id, $data));

        $data = static::$user_table_storage->get(static::$record_id);

        $this->assertEquals($data['first_name'], 'Janko');
        $this->assertEquals($data['last_name'], 'Króner');
        $this->assertEquals($data['user_name'], 'janko_kroner');

        return true;
    }

    /**
     * @depends testFillWithData
     */
    public function testFlushTable()
    {
        $this->assertTrue(static::$user_table_storage->truncate());
    }

    /**
     * @depends testInitUserTable
     */
    public function testDestroyUserTable()
    {
        $this->assertTrue(static::$user_table_storage->unsetup());
    }
}
