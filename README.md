# Kirby MemCachier Plugin

Activating this plugin will add the MemCachier caching driver and setup kirby to use it.

## Setup 

1. Copy the memcachier folder into site/plugins
2. Add the following config options to site/config/config.php

```php
c::set('memcachier', true);
```

This only sets the cache driver to MemCachier. You'll have to enable caching (`c::set('cache', true);`) to start caching pages in MemCachier. Make sure you have set the following environment variables before enabling the plugin. If you are using MemCachier Heroku add-on these environment variables are set as you add the memcachier resource to the project.

* MEMCACHIER_SERVERS
* MEMCACHIER_USERNAME
* MEMCACHIER_PASSWORD

You can also setup the prefix for cache keys by changing the following config option.

```
c::set('memcachier.prefix', 'prefix');
```

## Tested

This plugin has been tested on a kirby deployment on Heroku with the MemCachier add-on.

## Author
Baris Gumustas <http://twitter.com/matrushka>