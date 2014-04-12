<?
include('db.php');
include('functions.php');

$client = new Predis\Client(array(
  'host' => '127.0.0.1',
  'read_write_timeout' => 0
));

$urlList = explode("\n", $_POST['u']);
$name = trim(array_shift($urlList));
$ix = intval($_GET['o']);

if($ix == 0) {
  $client->publish($name, json_encode(Array(intval($_GET['t']), LISTSIZE)));
}

foreach($urlList as $url) {
  $url = trim($url);
  $url = explode('#', $url);
  $url = $url[0];

  if(! ($title = cached($url, 'full')) ) {
    if(gettype($title) != 'string') {
      $title = get_title($url);
    }

    set($title, $url, 'full');
  }
 
  $client->publish($name, json_encode(Array($title, $ix++)));

}
exit(0);
