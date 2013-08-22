<?php

// Boot
require_once dirname(dirname(dirname(__FILE__))).'/src/attitude/autoload.php';
use \attitude\Implementations\DependencyInjection\DependencyContainer as DependencyContainer;

// Class
class SomeFloatColumn extends \attitude\Abstracts\Storage\Column\Float
{
    public function __construct()
    {
        return parent::__construct();
    }
}

// Tests
class FloatColumnTest extends PHPUnit_Framework_TestCase
{
    public function test1()
    {
        DependencyContainer::set('SomeFloatColumn.decimals', 0);
        DependencyContainer::set('SomeFloatColumn.max', 255);
        DependencyContainer::set('SomeFloatColumn.min', -256);
        DependencyContainer::set('SomeFloatColumn.is_null', false);
        DependencyContainer::set('SomeFloatColumn.name', 'some_float_column');

        $int = new SomeFloatColumn();

        $this->assertEquals(
            $int->describe(),
            'DECIMAL(3,0)  NOT NULL'
        );
    }

    public function test2()
    {
        DependencyContainer::set('SomeFloatColumn.decimals', 3);
        DependencyContainer::set('SomeFloatColumn.max', 1024);
        DependencyContainer::set('SomeFloatColumn.min', -256);
        DependencyContainer::set('SomeFloatColumn.is_null', false);
        DependencyContainer::set('SomeFloatColumn.name', 'some_float_column');

        $int = new SomeFloatColumn();

        $this->assertEquals(
            $int->describe(),
            'DECIMAL(4,3)  NOT NULL'
        );
    }

    public function test3()
    {
        DependencyContainer::set('SomeFloatColumn.decimals', 3);
        DependencyContainer::set('SomeFloatColumn.max', 1024);
        DependencyContainer::set('SomeFloatColumn.min', -99999);
        DependencyContainer::set('SomeFloatColumn.is_null', false);
        DependencyContainer::set('SomeFloatColumn.name', 'some_float_column');

        $int = new SomeFloatColumn();

        $this->assertEquals(
            $int->describe(),
            'DECIMAL(5,3)  NOT NULL'
        );
    }
}
