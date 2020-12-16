<?php
require "Autoloader.php";
Autoloader::register();

$general = new General();

try {
    if (array_key_exists("entity", $_GET) && !empty($_GET["entity"])) {
        
        $class = ucfirst($_GET["entity"]);
        $controller = new $class();
        
        if (array_key_exists("method", $_GET)) {
            $method = $_GET["method"];
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'POST':
                    $controller->$method($_POST);
                    break;
            }
        } else { 
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    if (array_key_exists("id", $_GET)) {
                        $controller->getOne($_GET["id"]);
                    } else {
                        $controller->getAll();
                    }
                break;
                case 'POST':
                    if($class === "Product"){
                        $controller->postOne($_POST);
                    } else {
                        $general->sendError("400", "Method doesn't exist");
                    }
                break;
                case 'PUT':
                    if (array_key_exists("id", $_GET)) {
                        $controller->updateOne($_GET["id"], file_get_contents("php://input"));
                    } else {
                        $general->sendError("400", "id left");
                    }  
                break;
                case 'DELETE':
                    if ($class === "Stock") {
                        $general->sendError("400", "Method doesn't exist");
                    } else {
                        if (array_key_exists("id", $_GET)) {
                            $controller->deleteOne($_GET["id"], $_POST);
                        } else {
                            $general->sendError("400", "id left");
                        }  
                    }
                break;
            }
        }
            
    } else {
        $general->sendError(400, "Invalid URL");
    }
} catch (\Throwable $th) {
    $general->sendError($th->getCode(), $th->getMessage());
}