<?php

function correctName($controllerName)
{
    return ucfirst(strtolower($controllerName));
}
function getExceptionView($exception)
{
    $errorMessage = $exception;
    return include_once($_SERVER['DOCUMENT_ROOT'] . '/Views/' . 'ExceptionView.html');
}

//include_once($_SERVER['DOCUMENT_ROOT'].'/Controllers/HomeController.php');
//require_once ROOT.'/components/Router.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/DbConnection/Db.php';

$uri      = trim($_SERVER['REQUEST_URI'], '/');
$segments = explode('/', $uri);
array_shift($segments); //remove index.php
$controllerName = correctName(array_shift($segments)) . 'Controller';
$actionName     = correctName(array_shift($segments)) . 'Action';
$controllerFile = $_SERVER['DOCUMENT_ROOT'] . '/Controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    include_once($_SERVER['DOCUMENT_ROOT'].'/Controllers/Controller.php');
    include_once($controllerFile);
    $controllerObject = new $controllerName;
    if (!method_exists($controllerObject, $actionName)) {
        echo getExceptionView("404!actionNotFound");
    } else if ($segments != null) {
        echo call_user_func_array(array(
            $controllerObject,
            $actionName
        ), $segments);
    } else {
        echo $controllerObject->$actionName();
    }
} else {
    echo getExceptionView("404!controllerNotFound");
}

?>