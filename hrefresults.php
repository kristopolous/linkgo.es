<?
include('db.php');
include('functions.php');
header('Content-type: application/x-javascript');
$client = new Predis\Client(array(
  'host' => '127.0.0.1',
  'read_write_timeout' => 0
));

$pubsub = $client->pubSub();

$channel = $_GET['c'];
$pubsub->subscribe($channel);

$remaining = 0;
$all = array();

foreach ($pubsub as $message) {
  switch ($message->kind) {
    case 'message':
      $data = json_decode($message->payload, true);
      if($data[1] == LISTSIZE) {
        $remaining += $data[0];
      } else {
        if(strlen($data[0]) > 0) {
          $all[$data[1]] = $data[0];
        }
        $remaining --;
      }
      if($remaining == 0) {
        echo "self['$channel'](" . json_encode($all) . ");";
        unset($pubsub);
        exit(0);
      }
      break;
  }
}

