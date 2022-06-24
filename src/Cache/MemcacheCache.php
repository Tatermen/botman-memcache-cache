<?php

namespace BotMan\BotMan\Cache;

use BotMan\BotMan\Interfaces\CacheInterface;

class MemcacheCache implements CacheInterface
{
    const PREFIX = 'botman:';

    private $mc;

    public function __construct($servers = ['localhost:11211']) {
        $this->mc = new \Memcached;
        foreach($servers as $serv) {
            list($host,$port)=explode(':',$serv);
            $this->mc->addServer($host,$port);
        }
    }

    /**
     * Determine if an item exists in the cache.
     *
     * @param  string $key
     * @return bool
     */
    public function has($key)
    {
        $ret = $this->mc->get(self::PREFIX.$key);
        if ($ret == false) {
                return false;
        } else {
                return true;
        }
    }

    /**
     * Retrieve an item from the cache by key.
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $ret = $this->mc->get(self::PREFIX.$key);
        if ($ret==false) {
            return $default;
        } else {
            return $ret;
        }
    }

    /**
     * Retrieve an item from the cache and delete it.
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public function pull($key, $default = null)
    {
        $ret = $this->get($key,false);
        if ($ret == false) {
                return $default;
        } else {
                $this->mc->delete(self::PREFIX.$key);
                return $ret;
        }
    }

    /**
     * Store an item in the cache.
     *
     * @param  string $key
     * @param  mixed $value
     * @param  \DateTime|int $minutes
     * @return void
     */
    public function put($key, $value, $minutes)
    {
        if ($minutes instanceof \Datetime) {
                $seconds = $minutes->getTimestamp() - time();
        } else {
                $seconds = $minutes*60;
        }
        $this->mc->set(self::PREFIX.$key, $value, $seconds);
    }
}
