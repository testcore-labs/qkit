<?php
namespace core; 
require_once(dirname(__DIR__)."/core/bootstrap.php");
use core\conf;

class twig {
    private static function twig() {
        $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__)."/templates");
        $twig = new \Twig\Environment($loader, []);

        $twig->addGlobal('conf', new conf());
        
        return $twig;
    }

    public static function view($file, $data = []) {
        $twig = self::twig();

        if (!preg_match('/\.twig$/', $file)) {
        $file .= '.twig';
        }
        
        return $twig->render($file, $data);
    }
}