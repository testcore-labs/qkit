<?php
require(dirname(__DIR__).'/core/bootstrap.php');
use core\twig;
use core\route;
use core\conf;

use ScssPhp\ScssPhp\Compiler;

route::get('/docs/', function () {
    return twig::view("docs/index");
});
 
route::get('/g/{test}', function ($test) {
    return $test." | ".$_SERVER['REQUEST_URI'];
});

route::get('/', function () {
    return twig::view("index");
});

route::get('/css', function () {
$compiler = new Compiler();
return $compiler->compileString(file_get_contents(dirname(__DIR__)."/templates/core.scss"))->getCss();
}, ["Content-Type" => "text/css"]);