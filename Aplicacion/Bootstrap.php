<?php

require_once 'Controlador.php';
require_once 'Aplicacion/Config/configuration.php';
//require_once 'Librerias/Zend/Session/Namespace.php';

class Bootstrap
{

    protected $_appNamespace = 'Application';

    protected function __construct()
    {
        
    }

    protected function _initSession()
    {
         if (!Zend_Session::isStarted()) {
             Zend_Session::start();
         }
    }

    static function main()
    {
        require_once LIBRERIAS . 'Zend/Loader.php';
        Zend_Loader::registerAutoload();
        $autoloader = Zend_Loader_Autoloader::getInstance();
        Controlador::despachador();
    }

}
