<?
require('db.php');

$parts = explode('.', $_SERVER['HTTP_HOST']);

if (
  $_SERVER['REQUEST_METHOD'] == 'POST' || 
  count($parts) > 2
) {
  $type = $parts[0];
  require('transform.php');
} else if(!empty($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])) {
  echo file_get_contents("index.html");
} else if($redir = get($_GET['url'])) {
  header("Location: $redir", TRUE, 302);
} else {
  header("Location: error.html", TRUE, 404);
}
