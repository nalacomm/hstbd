<?php
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

$buildData = array();

/**
 * Change this url as necessary
 */
$buildData ["baseUrl"] = 'https://gmgworldmedia.com/hst-bdayvtwo/';

$buildData ["baseDir"] = __DIR__ . "/";
require_once $buildData ["baseDir"] . 'vendor/autoload.php';
$buildData ["incDir"] = $buildData ["baseDir"] . "inc/";
require_once $buildData ["incDir"] . 'init.php';
$buildData["month-date"] = "";
$buildData ["assetsDir"] = $buildData ["baseUrl"] . "assets/";
$buildData ["imageDir"] = $buildData ["baseUrl"] . "image/";
$buildData ["defaultTitle"] ="Check out what the Hubble Space Telescope looked at on my birthday! #Hubble30";
$router = new \Bramus\Router\Router();

$router->set404(function () {
    global $buildData;
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    $buildData["view"] = "404";
    render404($buildData);
});

$router->get('/image/(.*).jpg', function ($values = null) {
    global $buildData;
    $buildData["month-date"] = validatedInputResult($values);
    if($buildData["month-date"] === false){
        $buildData["view"] = "404";
        render404($buildData);
    } else  {
        renderImage($buildData);
    }
});

$router->get('/', function () {
    global $buildData;
    renderApp($buildData);
});

$router->get('/(.*)', function ($values = null) {
    global $buildData;
    $buildData["month-date"] = validatedInputResult($values);
    if($buildData["month-date"] === false){
        $buildData["view"] = "404";
        render404($buildData);
    } else  {
        renderApp($buildData);
    }
});

$router->run();

