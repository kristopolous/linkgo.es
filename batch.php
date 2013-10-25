<?
include('db.php');
include('functions.php');
header('Content-type: text/html');

$name = $_POST['fname'];
$urlList = explode("\n", $_POST['url']);
$ix = 0;
foreach($urlList as $url) {
  $url = trim($url);

  if(! ($title = cached($url, 'full')) ) {
    $title = get_title($url);
  }
  set($title, $url, 'full');

  ?><script>top.<?= $name ?>.cb(
    "<?= $title ?>", 
    <?= $ix++ ?>
  );</script>
  <?
  fflush(0);
}
