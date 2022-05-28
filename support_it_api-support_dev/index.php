<?php
define('ROOT', __DIR__ . '/');

require_once(ROOT . 'core/includes.php');

use Support\App\Api;
use Support\App\App;
use Steampixel\Route;
use Support\Users\Auth;

$app = new App();
$api = new Api();


// In development these shall be commented.
$api->cors()
    ->headers(['json']);

// Router
Route::add('/', function () {
    require_once('index.php');
});

Route::add('/auth/login', function () {
    require_once('./controller/auth/login.php');
}, 'post');

Route::add('/auth/init', function () {
    require_once('./controller/auth/init.php');
}, 'get');

Route::add('/auth/logout', function () {
    require_once('./controller/auth/logout.php');
}, 'post');

// Auto routing
Route::add($_SERVER['REQUEST_URI'], function () {
    global $app;
    $path = './controller' . $_SERVER['REQUEST_URI'] . '.php';

    if (file_exists($path)) {

        //Check if authentificated before routing
        new Auth('SP_token', true, false);

        require_once($path);
    } else {
        $app->error('You shall not pass!');
    }
}, $_SERVER['REQUEST_METHOD']);

// // Run the router
Route::run('/');
