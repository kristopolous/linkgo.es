<?
function get_title($url) {
  // parse the html
  $doc = new DOMDocument();
  @$doc->loadHTMLFile($url);
  $name = '';
  // use the title as the name
  $titleList = $doc->getElementsByTagName("title");
  foreach($titleList as $title) {
    $name = $title->nodeValue;
  }
  return $name;
}

