<?
function flush_buffers(){ 
  ob_end_flush(); 
  flush(); 
  ob_start(); 
}
function get_title($url) {
  static $uaList = Array(
    'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)',
    'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.41 Safari/537.36',
    'Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1667.0 Safari/537.36',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:25.0) Gecko/20100101 Firefox/25.0'
  );
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  curl_setopt($ch, CURLOPT_USERAGENT, array_rand($uaList));
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

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

