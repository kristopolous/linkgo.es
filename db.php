<?
//include('redis.php');
function redisLink() {
    static $r = false;

    if ($r) return $r;
    $r = new Redis();
    $r->connect('localhost');
    return $r;
}

function get($name) {
  $redis = redisLink();
  return $redis->hget("url", $name);
}

function set($name, $url) {
  $redis = redisLink();
  return $redis->hset("url", $name, $url);
}

