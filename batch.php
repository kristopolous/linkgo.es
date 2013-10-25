<?
include('functions.php');
header('Content-type: application/javascript');

foreach($_POST['url'] as $url) {
  ?>rt2(
    "<?= get_title($url) ?>",
    "<?= $url $?>"
  );<?
}
