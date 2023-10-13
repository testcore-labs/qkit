<?php
namespace core; 
use core\conf;

class route {
    private static $routes = [];
    public static $categories = [];

    // responses
    public static $r404;

    public static function __callStatic($name, $arguments) {
        $method = strtoupper($name);
        if (count($arguments) === 2 || count($arguments) === 4) {
            list($uri, $callback, $headers, $options) = array_pad($arguments, 4, []);
            self::addroute($method, $uri, $callback, $headers, $options);
        }
    }

    public static function addcategory($name, $func) {
        self::$categories[$name] = [
            'func' => $func,
        ];
    }

    private static function addroute($method, $uri, $callback, $headers = [], $options = []) {
        self::$routes[] = [
            'method' => $method,
            'uri' => $uri,
            'callback' => $callback,
            'headers' => $headers,
            'opts' => $options,
        ];
    }

    private static function matchdroute($method, $uri) {
        foreach (self::$routes as $route) {
            $pattern = str_replace('/', '\/', $route['uri']);
            $pattern = preg_replace('/\{([^\}]+)\}/', '([^\/]+)', $pattern);
            $pattern = '/^' . $pattern . '$/';

            $pattern = str_replace('*', '(.*)', $pattern);
            $pattern .= 'i';
    
            if($route['method'] === $method && preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                $matches = array_map('urldecode', $matches);
                foreach ($route['headers'] as $header => $value) {
                    header("$header: $value");
                }
                foreach ($route['opts']['category'] as $category) {
                    if (isset(self::$categories[$category])) {
                      if (is_callable(self::$categories[$category]["func"])) {
                        call_user_func_array(self::$categories[$category]["func"], [$route, $uri]);
                      }
                   }
                }
                return self::routeback($route['callback'], $matches);
            }
        }
        if (!in_array($uri, self::$routes)) {
            if(is_callable(self::$r404)) {
            return call_user_func_array(self::$r404, []);
            } else {
            return 404;
            }
        }
        return;
    }

    
    public static function init($method, $uri) {
        $uriparts = explode('?', $uri); // to ignore GET params in the url.
        $uri = $uriparts[0];
        $drouteresult = self::matchdroute($method, $uri);
        if ($drouteresult !== null) {
            return $drouteresult;
        }
    
        foreach (self::$routes as $route) {
            if ($route['method'] === $method && $route['uri'] === $uri) {
                foreach ($route['headers'] as $header => $value) {
                    header("$header: $value");
                }
                return self::routeback($route['callback']);
            }
        }
    
        return;
    }    

    private static function routeback($callback, $matches = []) {
        if (is_callable($callback)) {
            return call_user_func_array($callback, $matches);
        }
    
        return 500;
    }
}    

// im so well hidden!
if(conf::get()["fw"]["enableEasterEgg"]) {
route::get('/qkit', function () {
}, ["Location" => "//github.com/testcore-labs/qkit"]);
}

// yeah lol...
register_shutdown_function(function () {echo route::init(htmlspecialchars($_SERVER['REQUEST_METHOD']), htmlspecialchars($_SERVER['REQUEST_URI']));});