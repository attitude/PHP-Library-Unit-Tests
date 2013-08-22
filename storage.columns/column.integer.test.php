<?php

// Boot
require_once dirname(dirname(dirname(__FILE__))).'/src/attitude/autoload.php';
use \attitude\Implementations\DependencyInjection\DependencyContainer as DependencyContainer;

// Class
class SomeIntColumn extends \attitude\Abstracts\Storage\Column\Integer
{
    public function __construct()
    {
        return parent::__construct();
    }

    protected function helper_printRange()
    {
        echo "<{$this->min},{$this->max}>";
    }
}

// Tests
class IntColumnTest extends PHPUnit_Framework_TestCase
{
    public function test1()
    {
        DependencyContainer::set('SomeIntColumn.min', 0);
        DependencyContainer::set('SomeIntColumn.max', 255);
        DependencyContainer::set('SomeIntColumn.is_null', false);
        DependencyContainer::set('SomeIntColumn.name', 'some_int_column');

        $int = new SomeIntColumn();

        $this->assertEquals(
            $int->describe(),
            'TINYINT(1) UNSIGNED NOT NULL'
        );
    }

    public function test2()
    {
        DependencyContainer::set('SomeIntColumn.min', -128);
        DependencyContainer::set('SomeIntColumn.max', 127);
        DependencyContainer::set('SomeIntColumn.is_null', false);
        DependencyContainer::set('SomeIntColumn.name', 'some_int_column');

        $int = new SomeIntColumn();

        $this->assertEquals(
            $int->describe(),
            'TINYINT(1) NOT NULL'
        );
    }

    public function test3()
    {
        DependencyContainer::set('SomeIntColumn.min', 0);
        DependencyContainer::set('SomeIntColumn.max', 1024);
        DependencyContainer::set('SomeIntColumn.is_null', true);
        DependencyContainer::set('SomeIntColumn.name', 'some_int_column');

        $int = new SomeIntColumn();

        $this->assertEquals(
            $int->describe(),
            'SMALLINT(2) UNSIGNED NULL'
        );
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function test4()
    {
        DependencyContainer::set('SomeIntColumn.min', 0);
        DependencyContainer::set('SomeIntColumn.max', 256);
        DependencyContainer::set('SomeIntColumn.is_null', true);
        DependencyContainer::set('SomeIntColumn.name', 'some_int_column');

        $int = new SomeIntColumn();
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function test5()
    {
        DependencyContainer::set('SomeIntColumn.min', 0);
        DependencyContainer::set('SomeIntColumn.max', 256*256);
        DependencyContainer::set('SomeIntColumn.is_null', true);
        DependencyContainer::set('SomeIntColumn.name', 'some_int_column');

        $int = new SomeIntColumn();
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function test6()
    {
        DependencyContainer::set('SomeIntColumn.min', 0);
        DependencyContainer::set('SomeIntColumn.max', (pow(2, 64)+1));
        DependencyContainer::set('SomeIntColumn.is_null', true);
        DependencyContainer::set('SomeIntColumn.name', 'some_int_column');

        $int = new SomeIntColumn();
    }
}
