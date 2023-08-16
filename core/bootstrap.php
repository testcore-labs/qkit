<?php
require(dirname(__DIR__)."/vendor/autoload.php");
require(dirname(__DIR__)."/core/extras.php");
spl_autoload_register(function ($class_name) {
    include dirname(__DIR__).'/'.str_replace('\\', '/', $class_name).'.php';
});

/* core of tha app... */
use core\conf;

//  dirname(__dir__) is quite stupid, lets change that.
define('__FWDIR__', dirname(__DIR__));
// i know, $_SERVER['DOCUMENT_ROOT'] exist but uh no i wont use that :), ok time for other defines!11
define('__DB__', __FWDIR__."/database");
define('__DOMAIN__', $_SERVER['HTTP_HOST']);
define('__UA__', $_SERVER['HTTP_USER_AGENT']);


if(conf::get()['fw']['enableqKitHeaders']) {
header(conf::get()['fw']['name'].": ".conf::get()['fw']['version']);
}