<?php
require(dirname(__DIR__)."/vendor/autoload.php");
@include(dirname(__DIR__)."/core/modules/extras.php");
use core\conf;
spl_autoload_register(function ($class_name) {
    include dirname(__DIR__).'/'.str_replace('\\', '/', $class_name).'.php';
});

//  dirname(__dir__) is quite stupid, lets change that.
define('__FWDIR__', dirname(__DIR__));
// i know, $_SERVER['DOCUMENT_ROOT'] exist but uh no i wont use that :), ok time for other defines!11
define('__DB__', __FWDIR__."/database");
define('__SUBDOMAIN__', array_slice(explode('.', ($_SERVER['HTTP_HOST'] ?? null)),  0, count(explode('.', ($_SERVER['HTTP_HOST'] ?? null))) - 2));
@define('__REFERER__', $_SERVER['HTTP_REFERER'] ?? NULL);
define('__DOMAIN__', $_SERVER['HTTP_HOST'] ?? NULL);
define('__UA__', $_SERVER['HTTP_USER_AGENT'] ?? NULL);
define('__IP__', (isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER['REMOTE_ADDR'] ?? NULL) ?? NULL);
define('nil', null);
define('nan', null);
define('maybe', true); // as in check if its a maybe state
define('__TRANSDIR__', __FWDIR__.'/translations');
define('__URL__', $_SERVER['REQUEST_URI'] ?? NULL);
define('__METHOD__', $_SERVER['REQUEST_METHOD'] ?? NULL);
@define('__SESSION__', $_SESSION ?? NULL);
define('__COOKIE__', $_COOKIE ?? NULL);
define('__URL_NOQUERY__', explode('?', __URL__)[0] ?? NULL);
define('__PAGE__', str_replace(["_", ".php", "/"], [" ", "", " "], explode('?', ltrim((((__URL_NOQUERY__ ?? null) == "/") ? "index" : (__URL_NOQUERY__ ?? null)), "/") ?? "")[0]));
date_default_timezone_set(conf::get()['fw']['locale']);

// session_name("session");
// ini_set('session.save_path', __FWDIR__.'/cache/sessions');
// ini_set('session.gc_maxlifetime', (3600 * 2190));
// ini_set("session.gc_divisor", "1");
// ini_set("session.gc_probability", "1");
// session_set_cookie_params((3600 * 2190));
// ini_set("session.cache_expire", (3600 * 2190));
// ini_set("session.gc-probability", "0");
// session_start();

if(conf::get()['fw']['enableqKitHeaders']) {
header(conf::get()['fw']['name'].": ".conf::get()['fw']['version']);
}

if(conf::get()['fw']['debug']) {
    ini_set('display_errors', 1);
    error_reporting(1);
    //opcache_invalidate(__FILE__, true);
}

function import_plugin($file) {
return @include(__FWDIR__."/plugins/".$file);
}
