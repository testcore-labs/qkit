<?php
require(dirname(__DIR__).'/core/bootstrap.php');
use core\twig;
use core\route;
#use core\conf;

use ScssPhp\ScssPhp\Compiler;

// if(preg_match('/Firefox\/(\d+)/', __UA__, $matches)) {
// echo "Firefox $matches[1], nice :3 <br>";
// }

route::get('/docs/', function () {
    return twig::view("docs/index");
});

route::get('/ping', function () {
    $time_start = microtime(true);
    return 'Pong! ' . round((microtime(true) - $time_start) * 1000) . 'ms';
});

if(__DOMAIN__ === 'q.zip') {
    route::get('/', function () {
        return "brb gotta piss...";
    });
};

if(__DOMAIN__ === 'testtube.fun') {

route::get('/g/{test}', function ($test) {
    return $test." | ".$_SERVER['REQUEST_URI'];
});

/*route::get('/testies', function () {
    $testies = new \SleekDB\Store("test", __DB__);
    $balls = $testies->insert([
        "title" => "blah",
       ]);
    ob_clean(); // hey nosql KILL YASELF!!!!!111111323321214839343899
    return json_encode($balls);
}, ["Content-Type" => "application/json"]);*/


route::get('/', function () {
    return twig::view("index");
});

route::get('/css', function () {
    $compiler = new Compiler();
    return $compiler->compileString(file_get_contents(dirname(__DIR__)."/templates/core.scss"))->getCss();
}, ["Content-Type" => "text/css"]);

};