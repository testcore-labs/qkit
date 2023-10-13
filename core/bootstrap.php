<?php
require(dirname(__DIR__)."/vendor/autoload.php");
@include(dirname(__DIR__)."/core/modules/extras.php");
@include(dirname(__DIR__)."/core/modules/error.php");
use core\conf;

spl_autoload_register(function ($class_name) {
    include dirname(__DIR__).'/'.str_replace('\\', '/', $class_name).'.php';
});

//  dirname(__dir__) is quite stupid, lets change that.
define('__FWDIR__', dirname(__DIR__));
// i know, $_SERVER['DOCUMENT_ROOT'] exist but uh no i wont use that :), ok time for other defines!11
define('__DB__', __FWDIR__."/database"); // was used for SLEEKDB
define('__SUBDOMAIN__', array_slice(explode('.', $_SERVER['HTTP_HOST']),  0, count(explode('.', $_SERVER['HTTP_HOST'])) - 2));
define('__DOMAIN__', $_SERVER['HTTP_HOST']);
define('__UA__', $_SERVER['HTTP_USER_AGENT']);
define('__IP__', (isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER['REMOTE_ADDR']));
define('nil', null);
define('nan', null);
define('__TRANSDIR__', __FWDIR__.'/translations');
define('__URL__', $_SERVER['REQUEST_URI']);
define('__URL_NOQUERY__', explode('?', __URL__)[0]);
define('__PAGE__', str_replace(["_", ".php", "/"], [" ", "", " "], explode('?', ltrim((($_SERVER['REQUEST_URI'] == "/") ? "index" : $_SERVER['REQUEST_URI']), "/") ?? "")[0]));

if(conf::get()['fw']['enableqKitHeaders']) {
header(conf::get()['fw']['name'].": ".conf::get()['fw']['version']);
}

if(conf::get()['fw']['debug']) {
    ini_set('display_errors', 1);
    error_reporting(1);
}