<?php
require(dirname(__DIR__)."/vendor/autoload.php");
require(dirname(__DIR__)."/core/extras.php");
spl_autoload_register(function ($class_name) {
    include dirname(__DIR__).'/'.str_replace('\\', '/', $class_name).'.php';
});

/* core of tha app... */
use core\conf;

if(conf::get()['fw']['enableqKitHeaders']) {
header(conf::get()['fw']['name'].": ".conf::get()['fw']['version']);
}