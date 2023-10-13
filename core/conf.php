<?php
namespace core; 
use Symfony\Component\Yaml\Yaml;

class conf {
    public static function file() {
        return dirname(__DIR__)."/config.yaml";
    }
    public static function get() {
        return Yaml::parse(file_get_contents(self::file()));
    }
}