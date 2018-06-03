<?php declare(strict_types=1);

namespace ClickAndBoat;

use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Filesystem;

class Dependencies
{
    /**
     * @return \Auryn\Injector
     * @throws \Auryn\ConfigException
     */
    public static function getControllerDependencies(): \Auryn\Injector
    {
        $injector = new \Auryn\Injector;

        $injector->share('Symfony\Component\HttpFoundation\Request');
        $injector->define('Symfony\Component\HttpFoundation\Request', [
            ':query' => $_GET,
            ':request' => $_POST,
            ':attributes' => [],
            ':cookies' => $_COOKIE,
            ':files' => $_FILES,
            ':server' => $_SERVER
        ]);
        $injector->share('Symfony\Component\HttpFoundation\Response');

        $injector->delegate('Twig_Environment', function () use ($injector) {
            $loader = new Twig_Loader_Filesystem(dirname(__DIR__) . '/src/templates');
            $twig = new Twig_Environment($loader, ['debug' => true]);
            $twig->addExtension(new Twig_Extension_Debug());
            return $twig;
        });

        return $injector;

    }

    /**
     * Injection of PDO, remember to close the connection when needed
     *
     * @return mixed|\PDO
     * @throws \Auryn\ConfigException
     * @throws \Auryn\InjectionException
     */
    public static function getPDODependency()
    {
        $injector = new \Auryn\Injector;

        $injector->share('PDO');
        $injector->define('PDO', [
            ':dsn' => 'mysql:dbname=testclickandboat;host=127.0.0.1',
            ':username' => 'root',
            ':passwd' => ''
        ]);

        $db = $injector->make('PDO');

        return $db;
    }
}