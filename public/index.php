<?php

function register_module($name)
{
    if (file_exists("../app/modules/$name.php"))
        include "../app/modules/$name.php";
}

spl_autoload_register('register_module');

require_once '../vendor/autoload.php';
require_once '../app/rb.php';

$config = array(
    'dbhost' => 'localhost',
    'dbname' => 'bezposrednio',
    'dbuser' => 'root',
    'dbpass' => '',
    'debug' => false,
    'mode' => 'production',
    'cookies.encrypt' => true,
    'cookies.secret_key' => 'Far2ucE7eu5AB31173QsXSjSIG5jhn0sjgcBlxlVeNV3nRjL8',
    'view' => new \Slim\Views\Twig()
);

$app = new \Slim\Slim($config);

// Language
require_once "../app/lang/PL.php";
require_once "../app/lang/PL.front.php";

// Middleware
require_once "../app/middleware/CsrfGuard.php";

// Controllers
require_once "../app/controllers/Auth.php";
require_once "../app/controllers/Logon.php";
require_once "../app/controllers/Front.php";
require_once "../app/controllers/Admin.php";

require_once '../app/modules/Modules.php';

// Slim Facade
use SlimFacades\Facade;
Facade::setFacadeApplication($app);
Facade::registerAliases();
Config::set('debug', true);

// Slim Csrf Guard
use \Slim\Extras\Middleware\CsrfGuard;
$app->add(new CsrfGuard());

$view = $app->view();
$view->parserOptions = array(
    'debug' => true,
    'charset' => 'utf-8',
    'cache' => dirname(__FILE__) . '/cache',
    'auto_reload' => true,
    'strict_variables' => false,
    'autoescape' => true
);

$view->parserExtensions = array(
    new \Slim\Views\TwigExtension(),
);

$view->twigTemplateDirs = array(
    '../app/templates/admin',
    '../app/templates/admin/inc',
    '../app/templates/front',
    '../app/templates/front/inc',
    '../app/templates/errors'
);

R::setup('mysql:host='.$config['dbhost'].';dbname='.$config['dbname'], $config['dbuser'], $config['dbpass']);

// Configure Slim Auth components

use JeremyKendall\Password\PasswordValidator;
use JeremyKendall\Slim\Auth\Adapter\Db\PdoAdapter;
use JeremyKendall\Slim\Auth\Bootstrap;

$validator = new PasswordValidator();
$adapter = new PdoAdapter(getDb(), 'kudo_users', 'username', 'pass', $validator);
$acl = new \Auth\Acl();
$authBootstrap = new Bootstrap($app, $adapter, $acl);
$authBootstrap->bootstrap();

$app->add(new \Slim\Middleware\SessionCookie());

function close_db_connection()
{
    R::close();
}

register_shutdown_function('close_db_connection');

function getDb() {
    $config = array(
    'dbhost' => 'localhost',
    'dbname' => 'bezposrednio',
    'dbuser' => 'root',
    'dbpass' => '');

    $options = array(
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
    );

    try {
        $db = new PDO('mysql:host='.$config['dbhost'].';dbname='.$config['dbname'], $config['dbuser'], $config['dbpass'], $options);
    } catch (\PDOException $e) {
        die(sprintf('DB connection error: %s', $e->getMessage()));
    }

    /* SETUP ADMIN
    $admin = 'INSERT INTO kudo_users (username, pass, role) '
    . "VALUES ('apptelli', :pass, 'admin')";
    try {
        $admin = $db->prepare($admin);
        $admin->execute(array('pass' => password_hash('[1qaz2wsx3edc]', PASSWORD_DEFAULT)));
    } catch (\PDOException $e) {
        die(sprintf('DB setup error: %s', $e->getMessage()));
    } */
    
    return $db;
}

loadModules($app);

$app->run();