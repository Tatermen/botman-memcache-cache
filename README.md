# botman-memcache-cache
Memcache driver for Botman

Requires the [Memcache PECL extension](https://www.php.net/memcache).

# Installation

Drop into the src/Cache folder. Sorry, I don't know how to add it to composer.

# Usage

By default, it will attempt to connect to a Memcache server on localhost:11211. To use:

```
use BotMan\BotMan\Cache\MemcacheCache;

$botman = BotManFactory::create($config, new MemcacheCache());
```

If you want to specify one or more servers or alternative port numbers, use:

```
$servers = [
  'server1:11211',
  'server2:11212',
  'server3:5000',
];

$botman = BotManFactory::create($config, new MemcacheCache($servers));
```
