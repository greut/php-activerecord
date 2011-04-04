<?php
include 'helpers/config.php';
include_once 'ActiveRecordCacheTest.php';

use ActiveRecord\Cache;

class ActiveRecordCachedTest extends ActiveRecordCacheTest
{
	public function set_up($connection_name=null)
	{
		if (!extension_loaded('memcached'))
		{
			$this->markTestSkipped('The memcached extension is not available');
			return;
		}
		
		parent::set_up($connection_name);
		ActiveRecord\Config::instance()->set_cache('memcached://localhost');
	}
}
?>