<?php namespace Config;

    define("ROOT", dirname(__DIR__) . "/");
    //Path to your project's root folder
    define("FRONT_ROOT", "/TPFINAL/");
    define("VIEWS_PATH", "Views/");
    define("CSS_PATH", FRONT_ROOT.VIEWS_PATH . "default/");
    define("JS_PATH", FRONT_ROOT.VIEWS_PATH . "js/");
    define("IMG_PATH", CSS_PATH . "images/");

    define("DB_HOST", "localhost:3306");
    define("DB_NAME", "tpfinalthemovie");
    define("DB_USER", "root");
    define("DB_PASS", "");
    
    /*define("DB_HOST", "johnny.heliohost.org");
    define("DB_NAME", "juanfran_tpfinal");
    define("DB_USER", "juanfran_tpfinal");
    define("DB_PASS", "donpepito");*/
    

?>




