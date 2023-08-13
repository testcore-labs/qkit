<?php
namespace core; 
use core\conf;
use core\twig;

class route {
    private static $routes = [];

    public static function __callStatic($name, $arguments) {
        $method = strtoupper($name);
        if (count($arguments) === 2 || count($arguments) === 3) {
            list($uri, $callback, $headers) = array_pad($arguments, 3, []);
            self::addroute($method, $uri, $callback, $headers);
        }
    }

    private static function addroute($method, $uri, $callback, $headers = []) {
        self::$routes[] = [
            'method' => $method,
            'uri' => $uri,
            'callback' => $callback,
            'headers' => $headers,
        ];
    }

    private static function matchdroute($method, $uri) {
        foreach (self::$routes as $route) {
            $pattern = str_replace('/', '\/', $route['uri']);
            $pattern = preg_replace('/\{([^\}]+)\}/', '([^\/]+)', $pattern);
            $pattern = '/^' . $pattern . '$/';
    
            if ($route['method'] === $method && preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                $matches = array_map('urldecode', $matches);
                foreach ($route['headers'] as $header => $value) {
                    header("$header: $value");
                }
                return self::callRouteCallback($route['callback'], $matches);
            }
        }
    
        return twig::view("error", ["code" => 404]);
    }

    
    public static function init($method, $uri) {
        $drouteresult = self::matchdroute($method, $uri);
        if ($drouteresult !== null) {
            return $drouteresult;
        }
    
        foreach (self::$routes as $route) {
            if ($route['method'] === $method && $route['uri'] === $uri) {
                foreach ($route['headers'] as $header => $value) {
                    header("$header: $value");
                }
                return self::callRouteCallback($route['callback']);
            }
        }
    
        return twig::view("error", ["code" => 404]);
    }    

    private static function callRouteCallback($callback, $matches = []) {
        if (is_callable($callback)) {
            return call_user_func_array($callback, $matches);
        }
    
        return twig::view("error", ["code" => 500]);
    }
}    

// im so well hidden!
if(conf::get()["fw"]["enableEasterEgg"]) {
route::get('/qkit', function () {
}, ["Location" => "//github.com/testCore-labs/qkit"]);
}

// yeah lol...
register_shutdown_function(function () {echo route::init(htmlspecialchars($_SERVER['REQUEST_METHOD']), htmlspecialchars($_SERVER['REQUEST_URI']));});