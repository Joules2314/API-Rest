<?php 

    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(E_ERROR);

    define('HOST', 'localhost');
    define('BANCO', 'api');
    define('USER', 'root');
    define('PASSWORD', '');

    define('DS', DIRECTORY_SEPARATOR);
    define('DIR_APP', __DIR__);
    define('DIR_PROJETED', 'API_REST');

    if(file_exists(filename:'autoload.php')) {
        include 'autoload.php';
    }else {
        echo "Erro au incluir bootstrap"; exit;
    }
?>