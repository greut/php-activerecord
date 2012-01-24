<?php
include 'helpers/config.php';

use ActiveRecord\Cache;

class MemcacheActiveRecordCacheTest extends DatabaseTest
{
	public function set_up($connection_name=null)
	{
		if (!extension_loaded('memcache'))
		{
			$this->markTestSkipped('The memcache extension is not available');
			return;
		}

		if (!@memcache_connect('localhost')) {
			$this->markTestSkipped('The memcache server is not running');
		}

		parent::set_up($connection_name);
		ActiveRecord\Config::instance()->set_cache('memcache://localhost');
	}

	public function tear_down()
	{
		Cache::flush();
		Cache::initialize(null);
	}

	public function test_default_expire()
	{
		$this->assert_equals(30,Cache::$options['expire']);
	}

	public function test_explicit_default_expire()
	{
		ActiveRecord\Config::instance()->set_cache('memcache://localhost',array('expire' => 1));
		$this->assert_equals(1,Cache::$options['expire']);
	}

	public function test_caches_column_meta_data()
	{
		Author::first();

		$table_name = Author::table()->get_fully_qualified_table_name(false);
		$value = Cache::$adapter->read("get_meta_data-$table_name");
		$this->assert_true(is_array($value));
	}
}
?>
