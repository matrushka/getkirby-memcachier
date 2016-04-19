<?php
require_once(__DIR__ . DS . 'driver.php');
if(!c::get('memcachier')) return;

if(!getenv('MEMCACHIER_SERVERS')) trigger_error("Missing MEMCACHIER_SERVERS environment variable.", E_USER_ERROR);
if(!getenv('MEMCACHIER_USERNAME')) trigger_error("Missing MEMCACHIER_USERNAME environment variable.", E_USER_ERROR);
if(!getenv('MEMCACHIER_PASSWORD')) trigger_error("Missing MEMCACHIER_PASSWORD environment variable.", E_USER_ERROR);

if(getenv('MEMCACHIER_SERVERS') && getenv('MEMCACHIER_USERNAME') && getenv('MEMCACHIER_PASSWORD')) {
  kirby()->cache = cache::setup('memcachier', array('prefix' => c::get('memcachier.prefix')));
}