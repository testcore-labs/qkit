<?php
require(dirname(__DIR__).'/core/bootstrap.php');
use core\route;
use core\conf;

// example of the category usage
route::addcategory("hi", function () {
echo "im appearing at the top!\n";
});
route::addcategory("hello", function () {
echo "hello im the second one\n";
});

route::$r404 = function () {
return "nothing found!";
};

// routes
route::get('/test!{testie}!', function ($testing) {
	return $testing;
}, ["im a" => "header"], ["category" => ["hi", "hello"]]);

route::get('/returnnothing', function () {
}, ["im a" => "header"], ["category" => []]);

// trying to do GET will FAIL as its a OPTIONS http request
route::options('/test!', function () {
    $hello = [
    __FWDIR__,
    __DB__,
    __SUBDOMAIN__,
    __DOMAIN__,
    __UA__,
    __IP__,
    nil,
    nan,
    __TRANSDIR__,
    __URL__,
    __URL_NOQUERY__,
    __PAGE__,
    ];
    $testing = "";
    foreach($hello as $h) {
    $testing .= "$h\n";
    }
	return $testing;
}, ["im a" => "header"], ["category" => ["hello"]]);