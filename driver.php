<?php
namespace Cache\Driver;

// load dependencies
require_once(__DIR__ . DS . 'vendor' . DS . 'autoload.php');

use Cache\Driver;
use MemCachier\MemcacheSASL;

class MemCachier extends Driver {
  // store for the memache connection
  protected $connection = null;

  /**
   * Initialize memcachier connection.
   */
  public function __construct($params = array()) {
    $this->connection = new MemcacheSASL();

    $defaults = array(
      'prefix' => null,
    );

    $this->options = array_merge($defaults, (array)$params);

    $servers = explode(",", getenv("MEMCACHIER_SERVERS"));
    foreach ($servers as $server) {
      $parts = explode(":", $server);
      $this->connection->addServer($parts[0], $parts[1]);
    }

    // Setup authentication
    $this->connection->setSaslAuthData(getenv("MEMCACHIER_USERNAME")
                                      ,getenv("MEMCACHIER_PASSWORD") );

  }

  /**
   * Write an item to the cache for a given number of minutes.
   *
   * <code>
   *    // Put an item in the cache for 15 minutes
   *    Cache::set('value', 'my value', 15);
   * </code>
   *
   * @param  string  $key
   * @param  mixed   $value
   * @param  int     $minutes
   * @return void
   */
  public function set($key, $value, $minutes = null) {
    return $this->connection->set($this->key($key), $this->value($value, $minutes), $this->expiration($minutes));
  }

  /**
   * Returns the full keyname 
   * including the prefix (if set)
   * 
   * @param string $key
   * @return string 
   */
  public function key($key) {
    return $this->options['prefix'] . $key;
  }

  /**
   * Retrieve the CacheValue object from the cache.
   *
   * @param  string  $key
   * @return object CacheValue
   */
  public function retrieve($key) {
    return $this->connection->get($this->key($key));
  }

  /**
   * Remove an item from the cache
   *
   * @param string $key
   * @return boolean
   */
  public function remove($key) {
    return $this->connection->delete($this->key($key));
  }

  /**
   * Checks when an item in the cache expires
   *
   * @param string $key
   * @return int
   */
  public function expires($key) {
    return parent::expires($this->key($key));
  }

  /**
   * Checks if an item in the cache is expired
   *
   * @param string $key
   * @return int
   */
  public function expired($key) {
    return parent::expired($this->key($key));
  }

  /**
   * Checks when the cache has been created
   *
   * @param string $key
   * @return int
   */
  public function created($key) {
    return parent::created($this->key($key));
  }

  /**
   * Flush the entire cache directory
   *
   * @return boolean
   */
  public function flush() {
    return $this->connection->flush();
  }
}
