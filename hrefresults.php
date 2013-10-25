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

$remaining = 100;

foreach ($pubsub as $message) {
  switch ($message->kind) {
    case 'message':
      $data = json_decode($message->payload, true);
      if($data[1] == -2) {
        $remaining = $data[0];
      } else {
        echo "{$channel}({$message->payload});\r\n";
        flush_buffers();
        $remaining --;
      }
      if($remaining == 0) {
        echo "{$channel}(['',-1]);\r\n";
        unset($pubsub);
        exit(0);
      }
      break;
  }
}

