<?php

use Firebase\JWT\JWT;

require "Autoloader.php";
Autoloader::register();

require "vendor/autoload.php";

$general = new General();
$user = array();
if (array_key_exists("jwToken", $_COOKIE)) {
    $jwt = $_COOKIE["jwToken"];
    $key = "casier";
    $user = JWT::decode($jwt,$key,array('HS256'))->user;
}

$class = ucfirst($_GET["entity"]);
$controller = new $class();
$method = $_GET["method"];
$request = $_SERVER["REQUEST_METHOD"];

if(!empty($user)){
    if (in_array("ROLE_ADMIN", $user->role)) {
        if ($request == "GET" && ($method == "getAll" || $method == "maintenance" || $method == "activate" 
        || $method == "open" || $method == "close" )) {
            if (array_key_exists("id", $_GET)) {
                $controller->$method($_GET["id"]);
            } else {
                $controller->$method();
            }
        }
    } elseif(in_array("ROLE_USER", $user->role)){
        if ($request == "GET" && ($method == "open" || $method == "close" || $method == "getReserved")) {
            if (array_key_exists("id", $_GET)) {
                $controller->$method($_GET["id"]);
            } else {
                $controller->$method();
            }
        }
    }
} else {
    if ($request = "POST" && !$user && ($method == "login" || $method == "signup")) {
        $controller->$method($_POST);
    }
}