<?
include('db.php');
include('functions.php');

$client = new Predis\Client(array(
  'host' => '127.0.0.1',
  'read_write_timeout' => 0
));

$name = $_POST['f'];
$urlList = explode("\n", $_POST['u']);
$offset = $_GET['o'];
$ix = intval($offset);

if($ix == 0) {
  $client->publish($name, json_encode(Array(intval($_GET['t']), -2)));
}

foreach($urlList as $url) {
  $url = trim($url);

  echo "$url \r\n";
  flush_buffers();

  if(! ($title = cached($url, 'full')) ) {
    $title = get_title($url);
  }
  set($title, $url, 'full');

  $client->publish($name, json_encode(Array($title, $ix++)));
}
exit(0);
