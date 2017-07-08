<?php

use d0niek\Whereiscash\Core\DB\PdoDB;
use d0niek\Whereiscash\Core\DependenceInjection;
use d0niek\Whereiscash\Core\FrontController;
use d0niek\Whereiscash\Core\Kernel;
use d0niek\Whereiscash\Core\RepositoryManager;
use d0niek\Whereiscash\Http\Request;
use d0niek\Whereiscash\Core\Router;
use d0niek\Whereiscash\Http\Session;
use d0niek\Whereiscash\Model\RouteFactory;
use d0niek\Whereiscash\Service\PasswordHash;

$rootPath = dirname(dirname(__DIR__));
$di = DependenceInjection::getInstance();

$di->putParam('root_path', $rootPath);
$di->putParam('routes', require_once $rootPath . '/app/config/routes.php');
$di->putParam('controllers_namespace', 'd0niek\\Whereiscash\\Controller');
$di->putParam('repository_namespace', 'd0niek\\Whereiscash\\Repository');
$di->putParam('model_namespace', 'd0niek\\Whereiscash\\Model');
$di->putParam('view_path', $di->getParam('root_path') . '/app/view');
$di->putParam('hash_salt', 'baeec2b495c9922a1f928c15c1712ff228a7f6a8');
$di->putParam('hash_cost', 12);
$di->putParam('db_config', [
    'driver' => 'mysql',
    'db_name' => 'wykop_db',
    'host' => 'db',
    'port' => 3306,
    'user' => 'wykop_user',
    'password' => 'wykop_password',
]);

$di->put('db', PdoDB::getInstance($di->getParam('db_config')));
$di->put('password_hash', new PasswordHash($di->getParam('hash_salt'), $di->getParam('hash_cost')));
$di->put('request', new Request($_SERVER, $_GET, $_POST));
$di->put('session', Session::getInstance());
$di->put('router', new Router($di->getParam('routes'), new RouteFactory()));
$di->put('repository_manager', new RepositoryManager(
    $di->getParam('repository_namespace'),
    $di->getParam('model_namespace')
));
$di->put('front_controller', new FrontController(
    $di,
    $di->getParam('controllers_namespace'),
    $di->getParam('view_path')
));
$di->put('kernel', new Kernel(
    $di->get('request'),
    $di->get('router'),
    $di->get('front_controller')
));

$user = $di->get('session')->has('user') ? $di->get('session')->get('user') : null;
$di->put('user', $user);

return $di;
