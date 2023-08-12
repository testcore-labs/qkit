<?php
namespace core; 
use Symfony\Component\Yaml\Yaml;

class conf {
    public static function get() {
        return Yaml::parse(file_get_contents(dirname(__DIR__)."/config.yaml"));
    }
}