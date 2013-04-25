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

function cached($url) {
  return redis()->hget("urlrev", $url);
}

function get($name) {
  return redis()->hget("url", $name);
}

function set($name, $url) {
  $redis = redis();
  $redis->hset("url", $name, $url);
  $redis->hset("urlrev", $url, $name);
}

