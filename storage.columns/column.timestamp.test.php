<?php

date_default_timezone_set('Europe/Bratislava');

// Boot
require_once dirname(dirname(dirname(__FILE__))).'/src/attitude/autoload.php';
use \attitude\Implementations\DependencyInjection\DependencyContainer as DependencyContainer;

// Class
class SomeTimestampColumn extends \attitude\Abstracts\Storage\Column\Timestamp
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
class TimestampColumnTest extends PHPUnit_Framework_TestCase
{
    public function test1()
    {
        DependencyContainer::set('SomeTimestampColumn.seconds_since', strtotime('1000/01/01 00:00:00'));
        DependencyContainer::set('SomeTimestampColumn.seconds_until', strtotime('9999/01/01 23:59:59'));
        DependencyContainer::set('SomeTimestampColumn.is_null', false);
        DependencyContainer::set('SomeTimestampColumn.name', 'some_time_column');

        $int = new SomeTimestampColumn();

        $this->assertEquals(
            $int->describe(),
            'INT(5) NOT NULL'
        );
    }

    public function test2()
    {
        DependencyContainer::set('SomeTimestampColumn.seconds_since', strtotime('1980/01/01 00:00:00'));
        DependencyContainer::set('SomeTimestampColumn.seconds_until', strtotime('9999/01/01 23:59:59'));
        DependencyContainer::set('SomeTimestampColumn.is_null', false);
        DependencyContainer::set('SomeTimestampColumn.name', 'some_time_column');

        $int = new SomeTimestampColumn();

        $this->assertEquals(
            $int->describe(),
            'INT(5) UNSIGNED NOT NULL'
        );
    }
}
