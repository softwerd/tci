<?php
ob_start();
/* Reportar E_NOTICE puede ser bueno tambien (para reportar variables
 no inicializadas o capturar equivocaciones en nombres de variables ...) */
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

abstract class Index
{
    public function ejecutar ()
    {
        require_once 'Aplicacion/Librerias/Zend/Loader.php';
        require_once 'Aplicacion/Bootstrap.php';
        /* Se define el path de la aplicacion incluyendo el directorio aplicacion */
        defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/Aplicacion'));
        /* Se incluye en el path a la carpeta librerias y a la carpeta config */
        set_include_path(implode(PATH_SEPARATOR,
              array(realpath(APPLICATION_PATH . '/Librerias') ,
                    realpath(APPLICATION_PATH . '/Config'),
                    realpath(APPLICATION_PATH . '/Librerias/Zend'),
                    get_include_path()))
        );
        Bootstrap::main();
    }
}

Index::ejecutar();
ob_end_flush();

