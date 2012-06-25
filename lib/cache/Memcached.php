<?php
namespace ActiveRecord;

class Memcached
{
	const DEFAULT_PORT = 11211;

	private $memcache;

	/**
	 * Creates a Memcache instance.
	 *
	 * Takes an $options array w/ the following parameters:
	 *
	 * <ul>
	 * <li><b>host:</b> host for the memcache server </li>
	 * <li><b>port:</b> port for the memcache server </li>
	 * </ul>
	 * @param array $options
	 */
	public function __construct($options)
	{
		$this->memcache = new \Memcached();
		$options['port'] = isset($options['port']) ? $options['port'] : self::DEFAULT_PORT;

		$this->memcache->addServer($options['host'],$options['port']);
		if (!$this->memcache->getStats())
			throw new CacheException("Could not connect to $options[host]:$options[port]");
	}

	public function flush()
	{
		$this->memcache->flush();
	}

	public function read($key)
	{
		return $this->memcache->get($key);
	}

	public function write($key, $value, $expire)
	{
		$this->memcache->set($key,$value,$expire);
	}

	public function delete($key)
	{
		return $this->memcache->delete($key);
	}
}
?>