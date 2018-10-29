<?php

use Phalcon\Loader;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application as BaseApplication;

use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlProvider;

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

class Application extends BaseApplication
{
  protected function registerDirectories()
  {
    $loader = new Loader();

    // $loader->registerDirs(
    //   [
    //       "../app/controllers/",
    //       "../app/models/",
    //   ]
    // );

    $loader->registerDirs(
      [
          APP_PATH . '/controllers/',
          APP_PATH . '/models/',
      ]
    );

    $loader->register();
  }

  protected function setTheViewsDirectory()
  {
    $view = new View();
    $view->setViewsDir("../app/views/");
    // $view->setViewsDir(APP_PATH . '/views/');

    return $view;
  }

  protected function setTheBaseUri()
  {
    $url = new UrlProvider();
    $url->setBaseUri('/');

    return $url;
  }

  protected function setTheDb()
  {
    return new DbAdapter(array(
        "host"     => "localhost",
        "username" => "root",
        "password" => "1234",
        "dbname"   => "phalcon-test"
    ));
  }

  public function registerServices()
  {
    $di = new FactoryDefault();
    $di->setShared( 'view', $this->setTheViewsDirectory() );
    $di->set('url', $this->setTheBaseUri() );

    $this->setDI($di);
    $this->registerDirectories();
    $di->set('db', $this->setTheDb() );
  }

  public function init()
  {
    $this->registerServices();
    echo $this->handle()->getContent();
  }
}

$application = new Application();
$application->init();



