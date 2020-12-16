<?php

use Firebase\JWT\JWT;

require "Autoloader.php";
require "Vendor/autoload.php";
Autoloader::register();

$general = new General();

$role = array();
if (array_key_exists("apikey", $_COOKIE)) {
    $clientInst = new Client();
    $client = $clientInst->verifyKey($_COOKIE["apikey"]);
    if ($client) {
        $role = json_decode($client->role);
    }
}

$roleUser = array();
try{
    if(array_key_exists("jwToken", $_COOKIE)){
        $token = $_COOKIE["jwToken"];
        $key="toto";
        $decoded = JWT::decode($token, $key, array('HS256'));
        $roleUser = $decoded->role;
    }
} catch(\Throwable $th){
    $general->sendError(403, "Token expiré, veuillez vous reconnecter");
}

require "Routeur.php";