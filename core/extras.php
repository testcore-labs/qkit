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

function timeago(string|int $time) {
    if (is_numeric($time)) {
        $timestamp = (int) $time;
    } else {
        $timestamp = strtotime($time);
    }

    $timediff = time() - $timestamp;

    switch (true) {
        case $timediff === 0:
            return 'Just now';
        case $timediff < 60:
            return "$timediff second" . ($timediff !== 1 ? 's' : '') . ' ago';
        case $timediff < 3600:
            return floor($timediff / 60) . ' minute' . ($timediff < 120 ? '' : 's') . ' ago';
        case $timediff < 86400:
            return floor($timediff / 3600) . ' hour' . ($timediff < 7200 ? '' : 's') . ' ago';
        case $timediff < 604800:
            return floor($timediff / 86400) . ' day' . ($timediff < 172800 ? '' : 's') . ' ago';
        case $timediff < 2419200:
            return floor($timediff / 604800) . ' week' . ($timediff < 1209600 ? '' : 's') . ' ago';
        case $timediff < 29030400:
            return floor($timediff / 2419200) . ' month' . ($timediff < 4838400 ? '' : 's') . ' ago';
        default:
            return floor($timediff / 29030400) . ' year' . ($timediff < 58060800 ? '' : 's') . ' ago';
    }
}