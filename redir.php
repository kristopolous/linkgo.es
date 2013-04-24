<?
require('db.php');

$parts = explode('.', $_SERVER['HTTP_HOST']);

if ($_SERVER['REQUEST_METHOD'] == 'POST' || $parts[0] == 'a') {
  require('transform.php');
  // If this is a post, we need to convert a link and then return it
} else {
  // Otherwise, if it this is a get

  // and if this is blank query, we need to show the splash page "/"
  if (empty($_GET['url'])) {
    echo file_get_contents("splash.html");
    // Otherwise, we need to look this up and then do the redirect
  } else {
    $url = $_GET['url'];
    $redir = get($url);

    if($redir) {
      header("Location: $redir", TRUE, 302);
    } else {
      header("HTTP/1.0 404 Not Found");
      echo file_get_contents("error.html");
    }
  }
}
