<?php
//require_once LIBRERIAS . 'Zend_Date';

/**
 * Clase para manejar las fechas y horas
 * @see Zend_Date
 * @author Walter Ruiz Diaz
 */
class MyFechaHora
{
    function __construct()
    {
       
    }
    
    /**
     * Metodo para obtener la fecha en formato argentino
     * @param String $fecha
     * @return Zend_Date
     */
    public static function getFechaAr($fecha)
    {
            $myFecha = implode('/', array_reverse(explode('-', $fecha)));
            return $myFecha;
//        $myFecha = new Zend_Date($fecha, 'dd MM y');
//        $retorno = $date->get(Zend_Date::DATES);
    }
    
    public static function getFechaBd($fecha)
    {
//        $myFecha = new Zend_Date($fecha, 'y MM dd');
//        $retorno = $date->get(Zend_Date::DATES);
        $myFecha = implode('/', array_reverse(explode('/', $fecha)));
        return $myFecha;
    }
}

?>
