<?php

require_once LIBRERIAS . 'ModelBase.php';
require_once DIR_MODULOS . 'Inmuebles/Controlador/CriterioFiltro.php';
/**
 *  Clase para interactuar con la BD en el modulo Inmuebles
 *  @author Walter Ruiz Diaz
 *  @see Librerias_ModelBase
 *  @category Modelo
 *  @package Inmuebles
 */
class InmueblesModelo extends ModelBase
{

    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Guarda en la tabla inmuebles los datos del alumno
     * @param Array $datos corresponde a los datos a guardar
     * @return lastInsertId
     * @access Public 
     */
    public function guardar($datos=array())
    {
        try {
            $this->_db->insert('tci_inmuebles', $datos);
            return $this->_db->lastInsertId();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    /**
     * Guarda los datos de inscripcion del alumno
     * @param array $datos corresponde a los datos a guardar
     * @return lastInsertId 
     * @access Public
     */
    public function inscribir($datos=array())
    {
        try{
            $this->_db->insert('tci_inscripciones',$datos);
            return $this->_db->lastInsertId();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    /**
     * Actualiza los datos de la tabla Inmuebles
     * @param Array $datos son los datos a actualizar
     * @param string $where es la condición de la actualización
     */
    public function actualizar($tabla, $datos=array(), $where='')
    {
        $this->_db->update($tabla, $datos, $where);
    }
    
    /**
     * Actualiza los datos de la tabla Inscripcion
     * @param Array $datos son los datos a actualizar
     * @param string $where es la condición de la actualización
     */
    public function actualizarInscripcion($datos=array(), $where='')
    {
        $this->_db->update('tci_inscripciones', $datos, $where);
    }
    
    /**
     * Busca en la tabla inscripciones y inmuebles los datos de un alumno
     * inscripto.
     * @param array $where es la condición = el alumno a buscar
     * @return Zend_Db_Table_Row_Abstract|null 
     */
    public function buscarInscripto($where = array())
    {
        if (!is_array($where)) {
            throw new Zend_Exception("La condición de consulta no es válida");
        }
        $sql = new Sql();
        $sql->addFuncion('Select');
        $sql->addSelect('tci_inscripciones.id,
        		tci_inscripciones.idAlumno,
        		tci_inscripciones.idSalon,
                        tci_inscripciones.aLectivo
                        ');
        $sql->addTable('tci_inscripciones');
        foreach ($where as $condicion) {
            $sql->addWhere($condicion);
        }
        $sql->addFuncion('SELECT');
        $this->_db->setFetchMode(Zend_Db::FETCH_OBJ);
        $resultado = $this->_db->fetchRow($sql);
        return $resultado;
    }
    
    /**
     * Lista los inmuebles que no están inscriptos
     * @return Zend_Db_Table_Rowset_Abstract 
     */
    public function inmueblesParaInscripcion($aLectivo)
    {
        $aLectivo = substr($aLectivo, -4);
        $sql = 'SELECT * FROM tci_inmuebles as inmuebles
               WHERE inmuebles.eliminado = ' . $this->_verEliminados.
               ' AND inmuebles.id NOT IN ( 
               SELECT idAlumno 
               FROM tci_inscripciones as inscripciones
               WHERE inmuebles.id = inscripciones.idAlumno
               AND inscripciones.aLectivo=' . $aLectivo .
               ' AND inscripciones.eliminado = ' . $this->_verEliminados.
        ') ORDER BY apellidos';
//        echo $sql;
        $this->_db->setFetchMode(Zend_Db::FETCH_OBJ);
        $resultado = $this->_db->fetchAll($sql);
        return $resultado;
    }

    /**
     * Busca un alumno en la tabla inmuebles
     * @param array $where la condicion de la consulta = el alumno a buscar
     * @return Zend_Db_Table_Row_Abstract|null 
     */
    public function buscarAlumno($where = array())
    {
        if (!is_array($where)) {
            throw new Zend_Exception("La condición de consulta no es válida");
        }
        $sql = new Sql();
        $sql->addFuncion('Select');
        $sql->addSelect('tci_inmuebles.id,
        		tci_inmuebles.apellidos,
        		tci_inmuebles.nombres,
        		tci_inmuebles.nro_doc,
        		tci_inmuebles.domicilio,
        		tci_inmuebles.fechaNac,
        		tci_inmuebles.nacionalidad,
                        tci_inmuebles.sexo
                        ');
        $sql->addTable('tci_inmuebles');
        foreach ($where as $condicion) {
            $sql->addWhere($condicion);
        }
        $sql->addFuncion('SELECT');
        $this->_db->setFetchMode(Zend_Db::FETCH_OBJ);
        $resultado = $this->_db->fetchRow($sql);
        return $resultado;
    }
    
    /**public function listaInscriptos()
    {
        $sql = new Sql();
        $sql->addFuncion('Select');
        $sql->addTable('tci_inscripciones');
        try {
            $this->_db->setFetchMode(Zend_Db::FETCH_ASSOC);
            $result = $this->_db->fetchAll($sql);
            return $result;
        }catch (Exception $e) {
            echo $e->getMessage();
        }
        return $result;
    }*/
    
    /**
     * Funcion publica que devuelve un array de las inscripciones realizadas
     * @param int $ciclo el ciclo lectivo que quiero mostrar
     * @param int $salon el salon que quiero mostrar
     * @param String $filtro el filtro.
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function listaInmueblesInscriptos($inicio, $fin, $ciclo,$orden, $salon='0', $filtro='')
    {
        $campos = array('inscripciones.id', 'inmuebles.apellidos', 'inmuebles.nombres', 'salones.salon', 'salones.division');
        $sql = new Sql;
        foreach ($campos as $campo) {
            $sql->addSelect($campo);
        }
        $sql->addFuncion('Select');
        $sql->addTable('
        	tci_inscripciones AS inscripciones
                LEFT JOIN tci_inmuebles AS inmuebles 
                ON inmuebles.id = inscripciones.idAlumno
                LEFT JOIN tci_salones as salones 
                ON salones.id = inscripciones.idSalon
        ');
        $sql->addOrder($orden);
       
        $sql->addWhere('inscripciones.aLectivo = '.$ciclo);
        $sql->addWhere('inscripciones.eliminado=' . $this->_verEliminados);
        
        if ($filtro != ''){
            $sql->addWhere($filtro);
        }
        
        if ($fin != '0'){
            $sql->addLimit($inicio, $fin);
        }
        
        try {
            $this->_db->setFetchMode(Zend_Db::FETCH_ASSOC);
            $result = $this->_db->fetchAll($sql);
            return $result;
        }catch (Exception $e) {
            echo $e->getMessage();
        }
        return $result;
    }
    
    /**
     * Funcion publica que devuelve un array de las inscripciones realizadas
     * @param int $ciclo el ciclo lectivo que quiero mostrar
     * @param int $salon el salon que quiero mostrar
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function listaInmueblesInscriptosId($ciclo, $salon='0', $filtro='')
    {
        $campos = array('id', 'apellidos', 'nombres');
        $sql = new Sql;
        foreach ($campos as $campo) {
            $sql->addSelect($campo);
        }
        $sql->addFuncion('Select');
        $sql->addTable('
        	tci_inscripciones AS inscripciones
                LEFT JOIN tci_inmuebles AS inmuebles 
                ON inmuebles.id = inscripciones.idAlumno
                LEFT JOIN tci_salones as salones 
                ON salones.id = inscripciones.idSalon
        ');
        $sql->addTable('tci_inmuebles');
        $sql->addOrder('apellidos');
        $sql->addOrder('nombres');
        $sql->addWhere('eliminado=' . $this->_verEliminados);
        if ($filtro != ''){
            $sql->addWhere($filtro);
        }
//        $sql = 'SELECT inscripciones.id, inmuebles.apellidos, inmuebles.nombres, salones.salon
//FROM tci_inscripciones AS inscripciones
//LEFT JOIN tci_inmuebles AS inmuebles ON inmuebles.id = inscripciones.idAlumno
//LEFT JOIN tci_salones as salones ON salones.id = inscripciones.idSalon
//WHERE inscripciones.aLectivo = '.$ciclo.
//' ORDER BY salones.salon, inmuebles.apellidos, inmuebles.nombres;';

        try {
            $this->_db->setFetchMode(Zend_Db::FETCH_ASSOC);
            $result = $this->_db->fetchAll($sql);
            return $result;
        }catch (Exception $e) {
            echo $e->getMessage();
        }
        return $result;
    }

    /**
     * Lista los inmuebles de la tabla inmuebles
     * @param int $inicio. Desde donde se muestran los registros
     * @param string $orden. Los campos por los que se ordenan los datos
     * @param CriterioFiltro $filtro. Objeto con el criterio a filtrar
     * @param array $campos. Los campos a obtener de la tabla
     * @return Zend_Db_Table_Rowset_Abstract 
     */
    public function listadoInmuebles($inicio, $orden,  $filtro,  $campos=array('*'))
    {
        $sql = new Sql();
        foreach ($campos as $campo) {
            $sql->addSelect($campo);
        }
        $sql->addFuncion('Select');
        $sql->addTable('tci_inmuebles');
        $sql->addTable('
        	tci_tipoinmueble AS tipoinmueble
                LEFT JOIN tci_inmuebles AS inmuebles 
                ON inmuebles.id_tipo_inmueble = tipoinmueble.id
                LEFT JOIN tci_categorias as categoria 
                ON inmuebles.id_operacion = categoria.id
                LEFT JOIN tci_usuarios as usuario 
                ON inmuebles.id_propietario = usuario.id
        ');
        $sql->addOrder($orden);
        $sql->addWhere('inmuebles.eliminado=' . $this->_verEliminados);
        if (is_object($filtro)){
            $sql->addWhere($filtro->__toString());
        }
        $fin = $inicio + $this->_limite ;
        if ($fin > 0){
            $sql->addLimit($inicio, $fin);
        }
//        echo $sql;
        try {
            $this->_db->setFetchMode(Zend_Db::FETCH_ASSOC);
            $result = $this->_db->fetchAll($sql);
//            print_r($result);
            return $result;
        }catch (Exception $e) {
            echo $e->getMessage();
        }
        return $result;
    }

    /**
     * Obtiene la cantidad de registros de la tabla.
     * @param string $filtro. Filtro a considerar en la consulta.
     * @return int 
     */
    public function getCantidadRegistros($filtro='')
    {
        $sql = new Sql();
        $sql->addFuncion('Select');
        $sql->addSelect('tci_inmuebles.id
                        ');
        $sql->addTable('tci_inmuebles');
        
        if (!$filtro == '') {
            $sql->addWhere($filtro);
        }
        $this->_db->setFetchMode(Zend_Db::FETCH_ASSOC);
        $resultado = $this->_db->fetchAll($sql);
        return count($resultado);
    }

}
