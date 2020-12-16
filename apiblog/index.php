<?php
require "Autoloader.php";

Autoloader::register();
try {
    if (array_key_exists("entity", $_GET) && !empty($_GET["entity"])) {
        
        $class = ucfirst($_GET["entity"]);
        $controller = new $class();
        
        switch ($_SERVER["REQUEST_METHOD"]) {
            case 'GET':
                if (array_key_exists("id", $_GET)) {
                    $controller->getOne($_GET["id"]);
                } else {
                    $controller->getAll();
                }
                break;
            case 'POST':
                $controller->postOne($_POST);
                break;
            case 'PUT':
                $json = file_get_contents("php://input");
                $controller->updateOne($_GET["id"], $json);
            break;
            case 'DELETE':
                $controller->deleteOne($_GET["id"]);
                break;
        }

    } else {
        General::sendError(400, "Invalid URL");
    }
} catch (\Throwable $th) {
    General::sendError($th->getCode(), $th->getMessage());
}