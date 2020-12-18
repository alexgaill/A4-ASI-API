<?php

class Autoloader{

    public static function autoload($class){
        require "App/$class.php";
    }

    public static function register()
    {
        spl_autoload_register(array(__CLASS__, "autoload"));
    }
}