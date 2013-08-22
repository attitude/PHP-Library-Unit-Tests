<?php

// Boot
require_once dirname(dirname(dirname(__FILE__))).'/src/attitude/autoload.php';
use \attitude\Implementations\DependencyInjection\DependencyContainer as DependencyContainer;

// Class
class SomeUUIDColumn extends \attitude\Abstracts\Storage\Column\UUID
{
    public function __construct()
    {
        return parent::__construct();
    }
}

// Tests
class UUIDColumnTest extends PHPUnit_Framework_TestCase
{
    public function test1()
    {
        DependencyContainer::set('SomeUUIDColumn.name', 'test_uuid');

        $column = new SomeUUIDColumn;

        $this->assertEquals(
            $column->describe(),
            'BINARY(32) NOT NULL'
        );
    }

    public function testNextPrimaryKey()
    {
        DependencyContainer::set('SomeUUIDColumn.name', 'test_uuid');

        $column = new SomeUUIDColumn;

        $this->assertFalse(
            !!preg_match('|[^0-9abcdef]{2}|', '0a')
        );

        $this->assertTrue(
            !!preg_match('|[^0-9abcdef]{2}|', 'zz')
        );

        $this->assertFalse(
            !!preg_match('|[^0-9abcdef]{32}|', $column->nextPrimaryKey())
        );
    }
}
