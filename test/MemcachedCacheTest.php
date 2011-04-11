<?php
include 'helpers/config.php';
include_once 'MemcacheCacheTest.php';

use ActiveRecord\Cache;

class MemcachedCacheTest extends MemcacheCacheTest
{
	public function set_up()
	{
		if (!extension_loaded('memcached'))
		{
			$this->markTestSkipped('The memcached extension is not available');
			return;
		}

		Cache::initialize('memcached://localhost');
	}
}
?>