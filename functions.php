<?
function flush_buffers(){ 
  ob_end_flush(); 
  flush(); 
  ob_start(); 
}
function get_title($url) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 4);
  $data = curl_exec($ch);
  curl_close($ch);
  // parse the html
  $doc = new DOMDocument();
  @$doc->loadHTML($data);
  $name = '';
  // use the title as the name
  $titleList = $doc->getElementsByTagName("title");
  foreach($titleList as $title) {
    $name = $title->nodeValue;
  }
  return trim($name);
}

