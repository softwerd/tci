<?php

///require_once 'Aplicacion/Librerias/bd/BaseDeDatos.php';
//require_once LIBRERIAS . 'Bd/MySQL.php';
require_once LIBRERIAS . 'Bd/Sql.php';
//require_once 'Aplicacion/Librerias/Config.php';
require_once LIBRERIAS . 'Zend/Db/Table/Abstract.php';

/**
 *  Clase @abstract usada como base para las clases modelos
 *  @author Walter Ruiz Diaz
 *  @category Modelo
 *  @package Librerias
 *  @see Bd_MySql, Bd_Sql, Config
 */
abstract class ModelBase extends Zend_Db_Table_Abstract
{

    /**
     * Propiedad utilizada para definir la BD
     */
    protected $_db;

    /**
     *  Propiedad utilizada para definir si se muestran los registros eliminados 
     */
    protected $_verEliminados;

    /**
     * Indica cuantos registros por vez puede traer la lista
     * @var type Int
     */
    protected $_limite = 29;

    /**
     *  Metodo constructor
     *  Se crea la BD con los parametros necesarios
     */
    public function __construct()
    {
           
        $this->_db = new Zend_Db_Adapter_Pdo_Mysql(array(
                    'host' => 'localhost',
                    'username' => 'root',
                    'password' => '',
                    'dbname' => 'qa000324_tci'
                ));
        $this->_verEliminados = 'false'; //$this->_config->get('verEliminados');
    }

    public function setLimite($limite)
    {
        $this->_limite = intval($limite);
    }

}
