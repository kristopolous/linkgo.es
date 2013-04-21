<?
$url = trim($_POST['url']);

// find the hose name
$pieces = parse_url($url);
$host = $pieces['host'];

// remove annoying spurious www
$host = preg_replace('/^www\./', '', $host);

// split the domain into parts
$hostParts = explode('.', $host);

// get the nominative domain
$domain = $hostParts[0];

// parse the html
$doc = new DOMDocument();
@$doc->loadHTMLFile($url);

// use the title as the name
$titleList = $doc->getElementsByTagName("title");
foreach($titleList as $title) {
  $name = $title->nodeValue;
}

// clean it up to make the url usable
// dump the nominative domain if it appears at the beginning or end
$name = preg_replace('/^' . $domain . '/i', '', $name);
$name = preg_replace('/' . $domain . '$/i', '', $name);

// trim the white-space after the face
$name = trim($name, " \t\n\r\0\x0B-");
$name = preg_replace('/[\'\"?|]/', '', $name);
$name = preg_replace('/\s+/', '_', $name);

// try to see if it's available
$key = $base = "$host/$name";
$iter = 0;

for(;;) {
  // if it's been used before, then
  $value = get($key);

  // we can just use it again
  if($value == $url) {
    break;
  // otherwise, set it
  } else if(!$value) {
    set($key, $url);
    break;
  // otherwise we have a collision, so
  // we increment our name.
  } else {
    $key = "$base$iter";
    $iter++;
  }
}

echo json_encode(Array(
  "status" => true,
  "url" => $key,
  "destination" => $url
));

