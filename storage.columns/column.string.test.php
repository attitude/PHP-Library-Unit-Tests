<?php

// Boot
require_once dirname(dirname(dirname(__FILE__))).'/src/attitude/autoload.php';
use \attitude\Implementations\DependencyInjection\DependencyContainer as DependencyContainer;

// Class
class SomeStringColumn extends \attitude\Abstracts\Storage\Column\String
{
    public function __construct()
    {
        return parent::__construct();
    }
}

// Tests
class StringColumnTest extends PHPUnit_Framework_TestCase
{
    public function test1()
    {
        DependencyContainer::set('SomeStringColumn.length', 10);
        DependencyContainer::set('SomeStringColumn.is_varchar', false);
        DependencyContainer::set('SomeStringColumn.is_null', false);
        DependencyContainer::set('SomeStringColumn.name', 'test_string');

        $column = new SomeStringColumn;

        $this->assertEquals(
            $column->describe(),
            'CHAR(16) NOT NULL'
        );
    }

    public function test2()
    {
        DependencyContainer::set('SomeStringColumn.length', 128);
        DependencyContainer::set('SomeStringColumn.is_varchar', false);
        DependencyContainer::set('SomeStringColumn.is_null', true);
        DependencyContainer::set('SomeStringColumn.name', 'test_string');

        $column = new SomeStringColumn;

        $this->assertEquals(
            $column->describe(),
            'CHAR(128) NULL'
        );
    }

    public function test3()
    {
        DependencyContainer::set('SomeStringColumn.length', 256);
        DependencyContainer::set('SomeStringColumn.is_varchar', false);
        DependencyContainer::set('SomeStringColumn.is_null', true);
        DependencyContainer::set('SomeStringColumn.name', 'test_string');

        $column = new SomeStringColumn;

        $this->assertEquals(
            $column->describe(),
            'TEXT NULL'
        );
    }

    public function test4()
    {
        DependencyContainer::set('SomeStringColumn.length', 256*32);
        DependencyContainer::set('SomeStringColumn.is_varchar', false);
        DependencyContainer::set('SomeStringColumn.is_null', false);
        DependencyContainer::set('SomeStringColumn.name', 'test_string');

        $column = new SomeStringColumn;

        $this->assertEquals(
            $column->describe(),
            'TEXT NOT NULL'
        );
    }

    public function test5()
    {
        DependencyContainer::set('SomeStringColumn.length', 256*256);
        DependencyContainer::set('SomeStringColumn.is_varchar', false);
        DependencyContainer::set('SomeStringColumn.is_null', true);
        DependencyContainer::set('SomeStringColumn.name', 'test_string');

        $column = new SomeStringColumn;

        $this->assertEquals(
            $column->describe(),
            'MEDIUMTEXT NULL'
        );
    }

    public function test6()
    {
        DependencyContainer::set('SomeStringColumn.length', 256*256*256);
        DependencyContainer::set('SomeStringColumn.is_varchar', false);
        DependencyContainer::set('SomeStringColumn.is_null', false);
        DependencyContainer::set('SomeStringColumn.name', 'test_string');

        $column = new SomeStringColumn;

        $this->assertEquals(
            $column->describe(),
            'LONGTEXT NOT NULL'
        );
    }
}

