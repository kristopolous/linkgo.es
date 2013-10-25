<?
include_once('functions.php');

if(!isset($type)) {
  $type = 'json';
}
$url = @$_POST['url'];
if(strlen($url) == 0) {
  $url = urldecode(substr($_SERVER['REQUEST_URI'], 1));
}

if(preg_match('/^https?:/i', $url) == 0) {
  $url = "http://" . $url;
}

function done($url, $destination) {
  global $type;
  $url = "http://rt2.me/" . $url;
  if($type == 'raw') {
    echo $url;
  } else if($type == 'js') {
    header('Content-type: application/javascript');
    echo "rt2(\"$destination\",\"$url\");";
  } else {
    echo json_encode(Array(
      "url" => $url,
      "destination" => $destination
    ));
  }
  exit(0);
}

if($attempt = cached($url)) {
  done($attempt, $url);
}

// find the hose name
$pieces = parse_url($url);
$host = $pieces['host'];

// remove annoying spurious www
$host = preg_replace('/^www\./', '', $host);

// and a .com while you are at it
$host = preg_replace('/\.com$/', '', $host);

// split the domain into parts
$hostParts = explode('.', $host);

// get the nominative domain
$domain = $hostParts[0];

$name = get_title($url);

if(empty($name)) {
  done(true, $url, $url);
}

// clean it up to make the url usable
// dump the nominative domain if it appears at the beginning or end
$name = preg_replace('/^' . $domain . '/i', '', $name);
$name = preg_replace('/' . $domain . '$/i', '', $name);

// trim the white-space after the face
$name = trim($name, " \t\n\r\0\x0B-");
$name = preg_replace('/[:\&!\'\"?|]/', '', $name);
$name = trim($name, " \t\n\r\0\x0B-");
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

done($key, $url);

