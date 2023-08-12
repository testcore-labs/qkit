<?php
/* extra functions */

// htmlspecialchars shorterned 
function nxss(string $string, int $flags = ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, ?string $encoding = null, bool $double_encode = true): string {
return htmlspecialchars($string, $flags, $encoding, $double_encode);
}

// image proxy
function img2proxy(string $url, int $w, int $h): string {
$size = "&w=$w&h=$h"; // how it should be formatted for the size width and height
$proxy = "//wsrv.nl/";
return $proxy."?url=$url".$size;
}