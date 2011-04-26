<?php
namespace ActiveRecord;

class Memcached
{
	private $memcached;
    private $default_expire = 0;
    
	/**
	 * Creates a Memcached instance.
	 *
	 * @param array $servers Each entry in servers is supposed to be an array containing hostname, port, and, optionally, weight of the server
	 * @param array $options Specify additional options (http://www.php.net/manual/en/memcached.constants.php)
	 */
	public function __construct($ignore, $settings)
	{
		$this->memcached = new \Memcached();
		
		if (!is_array($settings) || !isset($settings['servers']))
		    throw new CacheException("You need to connect to at least one memcached server.");
		    
		if (!count($this->memcached->getServerList())) {
            $this->memcached->addServers($settings['servers']);
        }
        
		if (isset($settings['namespace']))
		    $this->memcached->setOption(\Memcached::OPT_PREFIX_KEY, $settings['namespace']);
		
		if (isset($settings['expire']))
		    $this->default_expire = $settings['expire'];
	    
        if (isset($settings['options'])) {
	        foreach ($settings['options'] AS $key=>$value) {
	            $this->memcached->setOption($key, $value);
		    }
		}
		
		if (!$this->memcached->getStats())
			throw new CacheException("Could not connect to $options[host]:$options[port]");
	}

	public function flush()
	{
		$this->memcached->flush();
	}

	public function read($key)
	{
	    $value = $this->memcached->get($key);
	    
	    if ($this->memcached->getOption(\Memcached::OPT_SERIALIZER) != \Memcached::SERIALIZER_IGBINARY && function_exists("igbinary_unserialize")) {
	        $value = igbinary_unserialize($value);
	    }
	    
		return $value;
	}

	public function write($key, $value, $expire)
	{
	    if ($this->memcached->getOption(\Memcached::OPT_SERIALIZER) != \Memcached::SERIALIZER_IGBINARY && function_exists("igbinary_serialize")) {
	        $value = igbinary_serialize($value);
	    }
	    
		$this->memcached->set($key,$value,$expire);
	}
}
?>