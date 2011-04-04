<?php
include 'helpers/config.php';
include_once 'CacheTest.php';

use ActiveRecord\Cache;

class CachedTest extends CacheTest
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