<?php

use Phalcon\Loader,
    Phalcon\DiInterface,
    Phalcon\Di\FactoryDefault,
    Phalcon\Mvc\Application as BaseApplication,
    Phalcon\Mvc\View,
    Phalcon\Mvc\Url as UrlProvider,
    Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter,
    Phalcon\Flash\Direct as FlashDirect,
    Phalcon\Flash\Session as FlashSession,
    Phalcon\Session\Adapter\Files as Session;

error_reporting(E_ALL);

define( 'BASE_DIR', dirname(__DIR__) );
define( 'APP_DIR', BASE_DIR . '/app' );

define( 'BASE_PATH', dirname(__DIR__));
define( 'APP_PATH', BASE_PATH . '/app');

class Application extends BaseApplication
{
    protected function registerAutoloaders()
    {
        $loader = new Loader();

        $loader->registerNamespaces([
            'Eaty\Libraries'    => APP_DIR . '/libraries/',
            'Eaty\Controllers'  => APP_DIR . '/controllers/',
            'Eaty\Models'       => APP_DIR . '/models/',
            'Eaty\Forms'        => APP_DIR . '/forms/'
        ]); 

        $loader->registerDirs([
            APP_PATH . '/libraries/',
            APP_PATH . '/controllers/',
            APP_PATH . '/models/',
            APP_PATH . '/forms/'
        ]);

        $loader->register();
    }

    protected function setViewsDirectory()
    {
        $view = new View();
        $view->setViewsDir("../app/views/");

        return $view;
    }
    
    protected function setDb()
    {
        return new DbAdapter(array(
        "host" => "localhost",
        "username" => "root",
        "password" => "1234",
        "dbname" => "phalcon-test"
        ));
    }

    protected function setBaseUri()
    {
        $url = new UrlProvider();
        $url->setBaseUri('/');

        return $url;
    }

    protected function setSession()
    {
        $session = new Session();
        $session->start();

        return $session;
    }

    protected function setFlashDirect()
    {
        $flash = new FlashDirect(
            [
                'error'   => 'alert alert-danger',
                'success' => 'alert alert-success',
                'notice'  => 'alert alert-info',
                'warning' => 'alert alert-warning',
            ]
        );

        return $flash;
    }

    protected function setFlashSession()
    {
        $flash = new FlashSession(
            [
                'error'   => 'alert alert-danger',
                'success' => 'alert alert-success',
                'notice'  => 'alert alert-info',
                'warning' => 'alert alert-warning',
            ]
        );

        return $flash;
    }

    public function registerServices()
    {
        $di = new FactoryDefault();

        $this->setDI($di);
        $this->registerAutoloaders();

        $di->set('db', $this->setDb());
        $di->setShared('view', $this->setViewsDirectory());
        $di->setShared('session', $this->setSession());
        $di->set('url', $this->setBaseUri());
        $di->set('flash', $this->setFlashDirect());
        $di->set('flashSession', $this->setFlashSession());
    }

    public function init()
    {
        $this->registerServices();
        echo $this->handle()->getContent();
    }
}

$application = new Application();
$application->init();



