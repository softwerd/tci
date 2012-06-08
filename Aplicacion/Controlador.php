<?php
require_once 'Librerias/Input.php';
require_once 'Librerias/Mensajes.php';
//    
require_once 'Config/configuration.php';
//include_once 'Librerias/Config.php';

/**
 *  Clase Controlador encargada de verificar lo que el usuario pide
 *  y realizar los pedidos necesarios
 *  @author Walter Ruiz Diaz
 *  @category Controlador
 *  @package Aplicacion
 */

class Controlador
{
//    private $_config; 
    
    /**
     * Funcion para verificar si el archivo de clase existe
     * @param string $class el nombre de la clase que quiero cargar
     * @return string el nombre de la clase controlador a cargar
     */
    private function _ifExisteClase ($class)
    {
        $file = DIRMODULOS . ucfirst($class) . '/Controlador/' . ucfirst($class) . 'Controlador.php';
        if (! file_exists($file)) {
            die('El controlador no existe - 404 not found');
        }
	require_once ($file);
        return $class . 'Controlador';
    }

    /**
     * la funcion despachador se encarga de decidir que debe hacer el soft
     * @access static public
     * @author Walter Ruiz Diaz
     * 
     */
    public static function despachador ()
    {
        require_once ZEND . 'Session/Namespace.php';
        $arg = NULL;
        $sesion = new Zend_Session_Namespace("didaskalos");
        //Me fijo si no hay consultas
        if (! $_GET) {
            //Controlador por defecto es el MENU
            $controlador = 'Inmuebles';
            //El método por defecto es el INDEX
            $metodo = 'listar';
        } else {
            //Me fijo si OPTION no esta vacio. Corresponde al controlador
            if (! empty($_GET['option'])) {
                $controlador = Input::get('option');
            } else {
                $controlador = 'Menu';
            }
            //Me fijo si SUB no está vacío. Corresponde al método
            if (! empty($_GET['sub'])) {
                $metodo = filter_input(INPUT_GET, 'sub', FILTER_SANITIZE_STRING);
            } else {
                $metodo = 'index';
            }
            if (! empty($_GET['resultado'])) {
                $resultado = '';
            } else {
                $resultado = filter_input(INPUT_GET, 'resultado', FILTER_SANITIZE_STRING);
            }
            //Me fijo si vinieron argumentos
            $urlArray = explode('&', trim($_SERVER['QUERY_STRING'], '?'));
            array_shift($urlArray);     //quito el  option
            array_shift($urlArray);     //quito el sub
            $arg = !empty($urlArray) ? $urlArray : NULL;
        }
        // Verifico si existe el archivo de clase
        $clase = self::_ifExisteClase($controlador);
        //verifico que la clase y método se puede cargar
        if (is_callable(array($clase , $metodo)) == false) {
            trigger_error($clase . '->' . $metodo . ' no existe', E_USER_NOTICE);
            return false;
        }
        // Creo el objeto con la clase
        $cont = new $clase();
        //Si tiene argumentos creo el metodo con esos argumentos
        if ($arg !== NULL) {
            $cont->$metodo($arg);
        } else {
            $cont->$metodo();
        }
    }

}
