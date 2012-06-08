<?php

/**
 *  Clase @abstract base para los controladores
 *  @author Walter Ruiz Diaz
 *  @category Controlador
 *  @package Librerias
 *  @see Zend_View, Zend_Layout
 */

abstract class ControladorBase {
    /* Propiedad usada para definir la vista */
    protected $_vista;
    /* Propiedad usada para definir el Layout */
    protected $_layout;
     
    function __construct()
    {
        /* Creo la Vista con Zend_View */
        $this->_vista = new Zend_View();
        require_once 'Zend/Layout.php';
        /* Creo el Layout */
        $this->_layout = new Zend_Layout();
//        // Set a layout script path:
        $this->_layout->setLayoutPath('site_media/html');
        $this->_layout->setLayout('layout');
    }
    
    /**
     * Metodo para redireccionar la pagina.
     * Recibe como parametro la url donde direccionar.
     * @param string $direccion 
     */
    protected function _redirect($direccion)
    {
        header ( "Location: " . "$direccion" );
    }
    
}