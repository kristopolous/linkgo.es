<?
require 'vendor/autoload.php';
define("LISTSIZE", -2);

Predis\Autoloader::register();

function redis(){
  static $redis;
  if(!$redis) {
    $redis = new Predis\Client();
  } 
  return $redis;
}

function cached($url, $key="url") {
  return redis()->hget($key . "rev", $url);
}

function get($name, $key="url") {
  return redis()->hget($key, $name);
}

function set($name, $url, $key="url") {
  $redis = redis();
  $redis->hset($key, $name, $url);
  $redis->hset($key . "rev", $url, $name);
}

