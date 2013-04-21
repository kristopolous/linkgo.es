<?
require 'vendor/autoload.php';

Predis\Autoloader::register();

function redis(){
  static $redis;
  if(!$redis) {
    $redis = new Predis\Client();
  } 
  return $redis;
}

function get($name) {
  $redis = redis();
  return $redis->hget("url", $name);
}

function set($name, $url) {
  $redis = redis();
  return $redis->hset("url", $name, $url);
}

