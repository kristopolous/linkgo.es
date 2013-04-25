<?
require('db.php');

$parts = explode('.', $_SERVER['HTTP_HOST']);

if (
  $_SERVER['REQUEST_METHOD'] == 'POST' || 
  count($parts) > 2
) {
  $type = $parts[0];
  require('transform.php');
} else if($redir = get($_GET['url'])) {
  header("Location: $redir", TRUE, 302);
} else {
  header("Location: error.html", TRUE, 404);
}
