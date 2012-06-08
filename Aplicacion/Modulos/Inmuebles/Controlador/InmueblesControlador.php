<?php

//require_once 'class/Usuario.php';
require_once 'Zend/View.php';
require_once LIBRERIAS . 'ControlarSesion.php';
//require_once 'Aplicacion/Librerias/Input.php';
//require_once 'Zend/Session/Namespace.php';
require_once 'Aplicacion/Librerias/ControladorBase.php';
//require_once 'Aplicacion/modelos/LoginModelo.php';
//require_once 'Aplicacion/Librerias/JQGrid.php';

/**
 *  Clase Controladora del Modulo Login
 *  @author Walter Ruiz Diaz
 *  @see ControladorBase
 *  @category Controlador
 *  @package Login
 * 
 */
class InmueblesControlador extends ControladorBase
{

    /**
     * Propiedad usada para la creacion de formularios
     * @var type Form 
     */
    protected static $_form;

    /**
     * Propiedad usada para enviar los elementos del formulario
     * @var type Array
     */
    private $_varForm = array();

    /**
     * Propiedad usada para establecer los campos de la BD
     * @var type Array
     * @example id,apellidos,nombres,domicilio,nro_doc,fechaNac,nacionalidad,sexo
     */
    private $_campos = array(
        'inmuebles.id',
        'usuario.nombre',
        'categoria.categoria',
        'tipoinmueble.tipo',
        'inmuebles.titulo',
        'inmuebles.descripcion',
        'inmuebles.servicios',
        'inmuebles.zona',
        'inmuebles.ambientes',
        'inmuebles.dormitorios',
        'inmuebles.banios',
        'inmuebles.sup_cubierta',
        'inmuebles.sup_total',
        'inmuebles.estado',
        'inmuebles.precio',
        'inmuebles.moneda',
        'inmuebles.pais',
        'inmuebles.provincia',
        'inmuebles.ciudad',
        'inmuebles.barrio_chacra',
        'inmuebles.ubicacion',
        'inmuebles.hits',
        'inmuebles.fecha_publicacion',
        'inmuebles.fecha_modificacion'
    );

    /**
     * Propiedad usada para establecer los títulos de los campos de la BD
     * @var type Array
     */
    private $_tituloCampos = array(
        'id' => 'Id',
        'id_propietario' => 'Propietario',
        'id_operacion' => 'Operación',
        'id_tipo_inmueble' => 'Tipo',
        'titulo' => 'Titulo',
        'descripcion' => 'Descripción',
        'servicios' => 'Servicios',
        'zona' => 'Zona',
        'ambientes' => 'Ambientes',
        'dormitorios' => 'Dormitorios',
        'banios' => 'Baños',
        'sup_cubierta' => 'Sup.Cub.',
        'sup_total' => 'Sup.Total',
        'estado' => 'Estado',
        'precio' => 'Precio',
        'moneda' => 'Moneda',
        'pais' => 'País',
        'provincia' => 'Provincia',
        'ciudad' => 'Ciudad',
        'barrio_chacra' => 'Barrio/Chacra',
        'ubicacion' => 'Ubicación',
        'hits' => 'Hits',
        'fecha_publicacion' => 'Publicado el',
        'fecha_modificacion' => 'Modificado el'
    );

    /**
     * Propiedad usada para acceder a los datos de la tabla salones
     * @var type SalonesModelo
     */
    private $_modeloSalones;

    /**
     * Propiedad usada para acceder a los datos de la tabla aLectivo
     * @var type CalendarioEscolarModelo
     */
    private $_modeloALectivo;

    /**
     * Propiedad usada para configurar el boton NUEVO
     * @var type Array
     */
    private $_paramBotonNuevoAlumno = array(
        'href' => 'index.php?option=inmuebles&sub=agregar',
        'classIcono' => 'icono-nuevoAlumno32'
    );

    /**
     * Propiedad usada para configurar el botón LISTA
     * @var type Array
     */
    private $_paramBotonListaInmuebles = array(
        'href' => 'index.php?option=inmuebles&sub=listar',
        'classIcono' => 'icono-listaInmuebles32'
    );

    /**
     * Propiedad usada para configurar el botón VOLVER
     * @var type Array
     */
    private $_paramBotonVolver = array('href' => 'index.php?option=inmuebles');

    /**
     * Propiedad usa para configurar el botón GUARDAR ALUMNO
     * @var type Array
     */
    private $_paramBotonGuardarAlumno = array(
        'href' => "\"javascript:void(0);\"",
        'evento' => "onclick=\"javascript: submitbutton('Guardar')\"",
    );

    /**
     * Propiedad usada para configurar el botón NUEVA INSCRIPCION
     * @var type Array
     */
    private $_paramBotonNuevaInscripcion = array(
        'href' => 'index.php?option=inmuebles&sub=inscribir',
        'classIcono' => 'icono-nuevaInscripcion32',
    );

    /**
     * Propiedad usada para configurar el botón LISTAR INSCRIPTOS
     * @var type Array
     */
    private $_paramBotonListaInscriptos = array(
        'href' => 'index.php?option=inmuebles&sub=listarInscriptos',
        'classIcono' => 'icono-listaInscripcion32'
    );

    /**
     * Propiedad usada para configurar el boton FILTRAR
     * @var type array
     */
    private $_paramBotonFiltrar = array(
        'class' => 'btn_filtrar',
        'evento' => "onclick=\"javascript: submitbutton('filtrar')\"",
        'href' => "\"javascript:void(0);\""
    );

    /* Construccion de la clase usando la clase padre
     * Se asignan los path a las vistas
     * Se construye el objeto modelo a utilizar
     */

    function __construct()
    {
        parent::__construct();
        $this->_vista->addScriptPath(DIRMODULOS . 'Inmuebles/Vista');
        require_once DIRMODULOS . 'Inmuebles/Modelo/InmueblesModelo.php';
        require_once DIRMODULOS . 'Salones/Modelo/SalonesModelo.php';
        require_once DIRMODULOS . 'CalendarioEscolar/Modelo/CalendarioEscolarModelo.php';
        $this->_modelo = new InmueblesModelo();
        $this->_modeloSalones = new SalonesModelo();
        $this->_modeloALectivo = new CalendarioEscolarModelo();
    }

    /**
     * Metodo para mostrar el menú principal de Inmuebles
     */
    public function index()
    {
        $this->_layout->content = $this->_vista->render('InmueblesVista.php');
        $this->_layout->setLayout('layout');
        echo $this->_layout->render();
    }

    /**
     * Método para inscribir un inmueble en un salón
     * El salón y el inmueble deben existir
     */
    public function inscribir()
    {
        require_once DIRMODULOS . 'Inmuebles/Forms/InscribirInmuebles.php';
        require_once LIBRERIAS . 'BarraHerramientas.php';
        /* esto es para que la lista de inmuebles no tenga limite */
        $this->_modelo->setLimite(0);
        /* traigo la lista de inscriptos */
//        $listaInscriptos = $this->_modelo->listaInscriptos();
        $ciclo = date('Y');
        /* traigo la lista de inmuebles aptos para inscripcion */
        $listaInmuebles = $this->_modelo->inmueblesParaInscripcion($ciclo);
        /* traigo los siguientes campos de la lista de salones */
        $campos = array('salones.id, salones.salon');
        /* traigo la lista sin limites */
        $this->_modeloSalones->setLimite(0);
        /* obtengo los datos de la bd */
        $listaSalones = $this->_modeloSalones->listadoSalones(0, 'salon', '', $campos);
        /* obtengo los datos de los ciclos lectivos */
        $listaCiclosLectivos = $this->_modeloALectivo->listadoCalendarios(0, 'aLectivo', '');
        foreach ($listaCiclosLectivos as $cicloLectivo) {
            $cicloLectivoArray[] = Array($cicloLectivo['aLectivo'] => $cicloLectivo['aLectivo']);
        }

        /* creo el formulario */
        $this->_form = new Form_InscribirInmuebles($listaInmuebles, $listaSalones, $cicloLectivoArray);
        /* pongo el formulario en la vista */
        $this->_vista->form = $this->_form->mostrar();
        if ($_POST) {
            if ($this->_form->isValid($_POST)) {
                $values = $this->_form->getValidValues($_POST);
                $inmuebles[] = $values['inmuebles'];
                $salon = $values['salones'];
                $aLectivo = $values['aLectivo'];
                foreach ($inmuebles[0] as $inmueble) {
                    $values = array('idAlumno' => $inmueble, 'idSalon' => $salon, 'aLectivo' => $aLectivo);
                    $this->_modelo->inscribir($values);
                }
                parent::_redirect('index.php?option=inmuebles&sub=listarInscriptos');
                $this->_vista->mensajes = Mensajes::presentarMensaje(DATOSGUARDADOS, 'info');
            }
        }
        $bh = new BarraHerramientas($this->_vista);
        $bh->addBoton('Guardar', $this->_paramBotonGuardarAlumno);
        $bh->addBoton('Nuevo', $this->_paramBotonNuevaInscripcion);
        $bh->addBoton('Lista', $this->_paramBotonListaInscriptos);
        $bh->addBoton('Volver', $this->_paramBotonVolver);

        $this->_vista->barraherramientas = $bh->render();
        $this->_layout->content = $this->_vista->render('AgregarInmueblesVista.php');
        // render final layout
        echo $this->_layout->render();
    }

    /**
     * Método que lleva a la pag donde se cargan los inmuebles
     * Recibe los datos a guardar por POST y los guarda.
     * @return void
     */
    public function agregar()
    {
        require_once DIRMODULOS . 'Inmuebles/Forms/CargaInmuebles.php';
        require_once LIBRERIAS . 'BarraHerramientas.php';
        require_once LIBRERIAS . 'MyFechaHora.php';
        $this->_form = new Form_CargaInmuebles($this->_varForm);
        $this->_vista->form = $this->_form->mostrar();
        if ($_POST) {
            if ($this->_form->isValid($_POST)) {
                $values = $this->_form->getValidValues($_POST);
                $values['fechaNac'] = MyFechaHora::getFechaBd($values['fechaNac']);
                $this->_modelo->guardar($values);
                $this->_vista->mensajes = Mensajes::presentarMensaje(DATOSGUARDADOS, 'info');
            }
        }
        $bh = new BarraHerramientas($this->_vista);
        $bh->addBoton('Guardar', $this->_paramBotonGuardarAlumno);
        $bh->addBoton('Nuevo', $this->_paramBotonNuevoAlumno);
        $bh->addBoton('Lista', $this->_paramBotonListaInmuebles);
        $bh->addBoton('Volver', $this->_paramBotonVolver);
        $this->_vista->barraherramientas = $bh->render();
        $this->_layout->content = $this->_vista->render('AgregarInmueblesVista.php');
        // render final layout
        echo $this->_layout->render();
    }

    /**
     * Metodo para editar los datos de un inmueble
     * @param Array $arg 
     * @access public
     */
    public function editar($arg)
    {
        require_once DIRMODULOS . 'Inmuebles/Forms/CargaInmuebles.php';
        include_once LIBRERIAS . 'MyFechaHora.php';
        require_once LIBRERIAS . 'BarraHerramientas.php';
        $inmuebleBuscado = $this->_modelo->buscarAlumno($arg);
        if (is_object($inmuebleBuscado)) {
            $this->_varForm['id'] = $inmuebleBuscado->id;
            $this->_varForm['id_propietario'] = $inmuebleBuscado->id_propietario;
            $this->_varForm['id_operacion'] = $inmuebleBuscado->id_operacion;
            $this->_varForm['id_tipo_inmueble'] = $inmuebleBuscado->id_tipo_inmueble;
            $this->_varForm['titulo'] = $inmuebleBuscado->titulo;
            $this->_varForm['descripcion'] = $inmuebleBuscado->descripcion;
            $this->_varForm['servicios'] = $inmuebleBuscado->servicios;
            $this->_varForm['zona'] = $inmuebleBuscado->zona;
            $this->_varForm['ambientes'] = $inmuebleBuscado->ambientes;
            $this->_varForm['dormitorios'] = $inmuebleBuscado->dormitorios;
            $this->_varForm['banios'] = $inmuebleBuscado->banios;
            $this->_varForm['sup_cubierta'] = $inmuebleBuscado->sup_cubierta;
            $this->_varForm['sup_total'] = $inmuebleBuscado->sup_total;
            $this->_varForm['estado'] = $inmuebleBuscado->estado;
            $this->_varForm['precio'] = $inmuebleBuscado->precio;
            $this->_varForm['moneda'] = $inmuebleBuscado->moneda;
            $this->_varForm['pais'] = $inmuebleBuscado->pais;
            $this->_varForm['provincia'] = $inmuebleBuscado->provincia;
            $this->_varForm['ciudad'] = $inmuebleBuscado->ciudad;
            $this->_varForm['barrio_chacra'] = $inmuebleBuscado->barrio_chacra;
            $this->_varForm['ubicacion'] = $inmuebleBuscado->ubicacion;
            $this->_varForm['hits'] = $inmuebleBuscado->hits;
            $this->_varForm['fecha_publicacion'] = $inmuebleBuscado->fecha_publicacion;
            $this->_varForm['fecha_modificacion'] = $inmuebleBuscado->fecha_modificacion;
        } else {
            $this->_varForm['id'] = '0';
            $this->_varForm['id_propietario'] = '';
            $this->_varForm['id_operacion'] = '';
            $this->_varForm['id_tipo_inmueble'] = '';
            $this->_varForm['titulo'] = '';
            $this->_varForm['descripcion'] = '';
            $this->_varForm['servicios'] = '';
            $this->_varForm['zona'] = '';
            $this->_varForm['ambientes'] = '';
            $this->_varForm['dormitorios'] = '';
            $this->_varForm['banios'] = '';
            $this->_varForm['sup_cubierta'] = '';
            $this->_varForm['sup_total'] = '';
            $this->_varForm['estado'] = '';
            $this->_varForm['precio'] = '';
            $this->_varForm['moneda'] = '';
            $this->_varForm['pais'] = '';
            $this->_varForm['provincia'] = '';
            $this->_varForm['ciudad'] = '';
            $this->_varForm['barrio_chacra'] = '';
            $this->_varForm['ubicacion'] = '';
            $this->_varForm['hits'] = '';
            $this->_varForm['fecha_publicacion'] = '';
            $this->_varForm['fecha_modificacion'] = '';
        }
        $this->_form = new Form_CargaInmuebles($this->_varForm);
        $this->_vista->form = $this->_form->mostrar();
        if ($_POST) {
            if ($this->_form->isValid($_POST)) {
                $values = $this->_form->getValidValues($_POST);
                $values['fechaNac'] = MyFechaHora::getFechaBd($values['fechaNac']);
                $this->_modelo->actualizar('conta_inmuebles', $values, $arg);
                $this->_vista->mensajes = Mensajes::presentarMensaje(DATOSGUARDADOS, 'info');
            }
        }
        $bh = new BarraHerramientas($this->_vista);
        $bh->addBoton('Guardar', $this->_paramBotonGuardarAlumno);
        $bh->addBoton('Nuevo', $this->_paramBotonNuevoAlumno);
        $bh->addBoton('Eliminar', array('href' => 'index.php?option=inmuebles&sub=eliminarAlumno&id=' . $this->_varForm['id']
        ));

        $bh->addBoton('Lista', $this->_paramBotonListaInmuebles);
        $bh->addBoton('Volver', $this->_paramBotonVolver);
        $this->_vista->barraherramientas = $bh->render();
        $this->_layout->content = $this->_vista->render('AgregarInmueblesVista.php');
        // render final layout
        echo $this->_layout->render();
    }

    /**
     * Metodo para eliminar una inscripcion.
     * La eliminacion no es real, sino que establece el campo 'eliminado' en verdadero
     * para no mostrarlo en las proximas oportunidades
     * @param Array $arg 
     * @access public
     */
    public function eliminarInscripcion($arg = '')
    {
        $where = implode(',', $arg);
        $values['eliminado'] = '1';
        $this->_modelo->actualizar('conta_inscripciones', $values, $arg);
        $this->_vista->mensajes = Mensajes::presentarMensaje(DATOSELIMINADOS, 'info');
        parent::_redirect(LIVESITE . '/index.php?option=inmuebles&sub=listarInscriptos');
    }

    /**
     * Metodo para eliminar un inmueble.
     * La eliminacion no es real, sino que establece el campo 'eliminado' en verdadero
     * para no mostrarlo en las proximas oportunidades
     * @param Array $arg 
     * @access public
     */
    public function eliminarAlumno($arg = '')
    {
        $where = implode(',', $arg);
        $values['eliminado'] = '1';
        $this->_modelo->actualizar('conta_inmuebles', $values, $arg);
        $this->_vista->mensajes = Mensajes::presentarMensaje(DATOSELIMINADOS, 'info');
        parent::_redirect(LIVESITE . '/index.php?option=inmuebles&sub=listar');
    }

    /**
     * Metodo para listar los inmuebles enla grilla.
     * @param Array $arg 
     * @access public
     * @see Librerias/Grilla.php, Librerias/BarraHerramientas.php
     */
    public function listar($arg = '')
    {
        require_once LIBRERIAS . 'JQGrid.php';
        require_once LIBRERIAS . 'BarraHerramientas.php';
        $grilla = new JQGrid('grilla');
        $grilla->setTitulo('INMUEBLES');
        $grilla->setUrl(LIVESITE . '/index.php?option=inmuebles&sub=jsonListarInmuebles');
        $grilla->setColNames(array(
            "'id'" => "'Id'",
            "'titulo'" => "'Titulo'",
            "'id_propietario'" => "'Operador'",
            "'id_operacion'" => "'Operación'",
            "'id_tipo_inmueble'" => "'Tipo'",
//        "'descripcion'"=>"'Descripción'",
//        "'servicios'"=>"'Servicios'",
            "'zona'" => "'Zona'",
//        "'ambientes'"=>"'Ambientes'",
//        "'dormitorios'"=>"'Dormitorios'",
//        "'banios'"=>"'Baños'",
//        "'sup_cubierta'"=>"'Sup.Cub.'",
//        "'sup_total'"=>"'Sup.Total'",
//        "'estado'"=>"'Estado'",
            "'precio'" => "'Precio'",
            "'moneda'" => "'Moneda'",
            "'pais'" => "'País'",
            "'provincia'" => "'Provincia'",
            "'ciudad'" => "'Ciudad'",
//        "'barrio_chacra'"=>"'Barrio/Chacra'",
//        "'ubicacion'"=>"'Ubicación'"
//        "'hits'"=>"'Hits'",
//        "'fecha_publicacion'"=>"'Publicado el'",
//        "'fecha_modificacion'"=>"'Modificado el'",
            "'foto'" => "'Foto'"
        ));

        $grilla->setColModel(array(
            array('name' => 'Id', 'index' => 'id', 'width' => '30', 'align' => "right"),
            array('name' => 'Titulo', 'index' => 'titulo', 'width' => '180'),
            array('name' => 'Operador', 'index' => 'id_propietario', 'width' => '155'),
            array('name' => 'Operación', 'index' => 'id_operacion', 'width' => '60'),
            array('name' => 'Tipo', 'index' => 'id_tipo_inmueble', 'width' => '80'),
//            array('name' => 'Descripción', 'index' => 'descripcion', 'width' => '55'),
//            array('name' => 'Servicios', 'index' => 'servicios', 'width' => '155'),
            array('name' => 'Zona', 'index' => 'zona', 'width' => '155'),
//            array('name' => 'Ambientes', 'index' => 'ambientes', 'width' => '255'),
//            array('name' => 'Dormitorios', 'index' => 'dormitorios', 'width' => '40', 'align'=>"right"),
//            array('name' => 'Baños', 'index' => 'banios', 'width' => '40', 'align'=>"right"),
//            array('name' => 'Sup.Cub.', 'index' => 'sup_cubierta', 'width' => '155'),
//            array('name' => 'Sup.Total', 'index' => 'sup_total', 'width' => '155'),
//            array('name' => 'Estado', 'index' => 'estado', 'width' => '100'),
            array('name' => 'Precio', 'index' => 'precio', 'width' => '55', 'align' => "right", 'formatter' => 'currency'),
            array('name' => 'Moneda', 'index' => 'moneda', 'width' => '55'),
            array('name' => 'País', 'index' => 'pais', 'width' => '60'),
            array('name' => 'Provincia', 'index' => 'provincia', 'width' => '50'),
            array('name' => 'Ciudad', 'index' => 'ciudad', 'width' => '50'),
//            array('name' => 'Barrio/Chacra', 'index' => 'barrio_chacra', 'width' => '55'),
//            array('name' => 'Ubicación', 'index' => 'ubicacion', 'width' => '55'),
//            array('name' => 'Hits', 'index' => 'hits', 'width' => '155'),
//            array('name' => 'Publicado el', 'index' => 'fecha_publicacion', 'width' => '155'),
//            array('name' => 'Modificado el', 'index' => 'fecha_modificacion', 'width' => '255')
            array('name' => 'Foto', 'index' => 'foto', 'width' => '50'),
        ));
        $grilla->setIfBotonEditar(FALSE);
        $grilla->setIfBotonEliminar(FALSE);
        $grilla->setIfBotonBuscar(FALSE);
//        $grilla->setOnDblClickRow(TRUE);
//        $grilla->setActionOnDblClickRow('/index.php?option=ingresos&sub=editar&id=');

        $bh = new BarraHerramientas($this->_vista);
        $bh->addBoton('Nuevo', $this->_paramBotonNuevaInscripcion);
        $bh->addBoton('Filtrar', $this->_paramBotonFiltrar);
        if (is_array($arg)) {
            $filtroBoton = '&' . implode("&", $arg) . '&lista=inscriptos';
        } else {
            $filtroBoton = '&lista=inscriptos';
        }
        $bh->addBoton('Exportar', array('href' => 'index.php?option=inmuebles&sub=exportar' . $filtroBoton,
        ));
        $bh->addBoton('Volver', $this->_paramBotonVolver);
        $this->_vista->barraherramientas = $bh->render();
        $this->_vista->grid = $grilla->incluirJs();
        $this->_layout->content = $this->_vista->render('ListadoInmueblesVista.php');
        echo $this->_layout->render();
    }

    public function jsonListarInmuebles($arg = '')
    {
        /** Me fijo si hay argumentos */
        if (isset($arg)) {
            /** Me fijo si existe el argumento page */
            if (!empty($_GET['page'])) {
                $pag = Input::get('page');
            } else {
                $pag = 1;
            }
            $inicio = ($pag - 1) * 30;
            /** Me fijo si existe el argumento de orden */
            if (!empty($_GET['sidx'])) {
                $orden = Input::get('sidx');
                switch ($orden) {
                    case 'id':
                    case 'titulo':
                    case 'zona':
                    case 'precio':
                    case 'moneda':
                    case 'pais':
                    case 'provincia':
                    case 'ciudad':
                        $orden = 'tci_inmuebles.'.$orden;
                        break;
                    case 'id_tipo_inmueble':
                        $orden = 'tci_tipoinmueble.'.$orden;
                        break;
                    case 'id_operacion':
                        $orden = 'tci_categorias.'.$orden;
                        break;
                    default:
                        break;
                }
            } else {
                $orden = 'tci_inmuebles.id';
            }
            /** Me fijo si el argumento es el tipo de orden (ASC o DESC) */
            if (!empty($_GET['sord'])) {
                $orden .= ' ' . Input::get('sord');
            } else {
                $orden .= ' ASC';
            }
            /** Si el argumento es un array entonces creo el filtro */
            if (is_array($arg)) {
                $filtroBoton = '&' . implode("&", $arg);
            } else {
                $filtroBoton = '';
            }
        }
        $json = new Zend_Json();
        $todos = $this->_modelo->getCantidadRegistros();
        $total_pages = ceil(count($todos) / 30);
        $result = $this->_modelo->listadoInmuebles($inicio, $orden, '', $this->_campos);
        $count = count($result);
        $responce->page = $pag;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;

        foreach ($result as $row) {
            $responce->rows[$i]['id'] = $row['id'];
            $responce->rows[$i]['cell'] = array($row['id'],
                $row['titulo'],
                $row['nombre'],
                $row['categoria'],
                $row['tipo'],
//                $row['descripcion'],
                $row['zona'],
//                $row['ambientes'],
//                $row['dormitorios'],
//                $row['banios'],
//                $row['sup_cubierta'],
//                $row['sup_total'],
//                $row['estado'],
                $row['precio'],
                $row['moneda'],
                $row['pais'],
                $row['provincia'],
                $row['ciudad'],
//                $row['barrio_chacra'],
//                $row['ubicacion']
//                $row['hits'],
//                $row['fecha_publicacion'],
//                $row['fecha_modificacion']
                '<img src="' . IMG . 'fotos/id' . $row['id'] . '.png" class="foto_usuario_32"',
            );
            $i++;
        }
        // return the formated data
        echo $json->encode($responce);
    }

    /**
     * Metodo para traer la lista de los inmuebles inscriptos.
     * @param string $arg. El ciclo lectivo
     * @access public
     */
    public function ajaxInmueblesParaInscribir($arg = '')
    {
        if ($arg == '') {
            $ciclo = date('Y');
        } else {
            $ciclo = $arg[0];
        }
        print_r($arg);
        $salon = 0;
        $fuenteDatos = $this->_modelo->inmueblesParaInscripcion($ciclo);
        /** Lista de inmuebles * */
        $retorno = '';
        $i = 0;
        foreach ($fuenteDatos as $inmueble) {
//            $opcionListaInmuebles[]=array($inmueble->id => $inmueble->apellidos .', ' . $inmueble->nombres);
            $retorno .= '<optgroup id="inmuebles-optgroup-0" label="' . $i . '">';
            $retorno .= '<option value="' . $inmueble->id . '">';
            $retorno .= $inmueble->apellidos . ', ' . $inmueble->nombres . '</option>';
            $retorno .= ' </optgroup>';
            $i++;
        }
        print_r($retorno);
        return $retorno;
    }

    private function _mostrarGrafico()
    {
        $retorno = '<img src="http://chart.apis.google.com/chart?cht=';
        $retorno .= 'p3'; //tipo de grafico
        $retorno .= '&chs=400x175'; //tamaño del grafico
        $retorno .= '&chd=t:45,32,17'; //chd Especifica los datos de la gráfica. Por ejemplo t:45,32,17. El primer carácter t indica que los datos se representan en formato de texto básico, es decir, valores comprendidos entre 0 y 100 separados por comas.
        $retorno .= '&chl=Diseño|Programación|Otras+cosas';  //chl Indica las etiquetas de cada elemento de la gráfica. Por ejemplo chl=Diseño|Programación|Otras+cosas.
        $retorno .= '&chtt=Inmuebles+Inscriptos';  //chtt Establece el título de la gráfica. Por ejemplo: chtt=Posts+en+Theproc.es.
        $retorno .= '&chco=ff0000'; //chco Establece el color de los elementos del gráfico. Por ejemplo: ff0000.
//        En el caso de las gráficas de tipo tarta los distintos elementos se muestran con varias tonalidades de dicho color. También se puede especificar un color por elemento, como en el ejemplo de gráfica barras chco=FF9999|99FF99|9999FF.
        $retorno .= '&chf=bg,s,ffffff" id="grafico" alt="grafico">'; //chf Establece el color de fondo de la gráfica. En los ejemplos anteriores he usado de fondo el mismo color que el fondo del blog para que se integre perfectamente bg,s,fff6f6, es decir, background color, solid, fff6f6.
        return $retorno;
    }

    private function _crearFiltro($pag)
    {
        $filtro = '';
        $valorRecibido = Input::get('valor');
        if ($valorRecibido != 'valor' && $valorRecibido != '') {
            $campoRecibido = Input::get('campo');
            $clase = self::_ifExisteClase($campoRecibido);
            $file = DIRMODULOS . 'Inmuebles/Controlador/' . $clase . '.php';
            require_once ($file);
            $filtro = new $clase($valorRecibido);
        }
        return $filtro;
    }

    private function _ifExisteClase($class)
    {
        $file = DIRMODULOS . 'Inmuebles/Controlador/' . 'Filtro' . ucfirst($class) . '.php';
        if (!file_exists($file)) {
            die('No se puede crear el filtro');
        }
        return 'Filtro' . ucfirst($class);
    }

    public function exportar($filtro = '')
    {
        require_once LIBRERIAS . 'ExportToExcel.php';
        $exp = new ExportToExcel();
        $filtro = $this->_crearFiltro($filtro);
        if (isset($filtro)) {
            if (!empty($_GET['pg'])) {
                $pag = Input::get('pg');
            } else {
                $pag = 1;
            }
            $inicio = 0 + ($pag - 1) * 30;
            if (!empty($_GET['sidx'])) {
                $orden = Input::get('sidx');
            } else {
                $orden = 'salones.salon, salones.division, inmuebles.apellidos, inmuebles.nombres';
            }
        }
        if (Input::get('lista') == 'inscriptos') {
            $ciclo = date('Y');
            $salon = 0;
            $exp->setTitulo('LISTADO DE ALUMNOS INSCRIPTOS');
            $tituloCampos = array(
                'id' => 'Id',
                'apellidos' => 'Apellidos',
                'nombres' => 'Nombres',
                'salon' => 'Salón',
                'division' => 'Div.'
            );
            foreach ($tituloCampos as $key => $value) {
                $encCol[] = $value;
            }
            $encBD = array(
                'id',
                'apellidos',
                'nombres',
                'salon',
                'division'
            );
            $exp->setFormatoCol(array(
                'id' => 'entero'
            ));
            $datos = $this->_modelo->listaInmueblesInscriptos(0, 0, $ciclo, $orden, $salon, $filtro);
        } else {
            $exp->setTitulo('LISTADO DE ALUMNOS');
            foreach ($this->_tituloCampos as $key => $value) {
                $encCol[] = $value;
            }
            $encBD = $this->_campos;
            $exp->setFormatoCol(array(
                'id' => 'entero',
                'nro_doc' => 'entero',
                'fechaNac' => 'fecha'
            ));
            $inicio = 0;
            $datos = $this->_modelo->listadoInmuebles($inicio, $orden, $filtro, $this->_campos);
        }
        $encCol = implode(',', $encCol);
        $exp->setEncabezadoPagina('&L&G&C&HPequeno Hogar 0476');
        $exp->setPiePagina('&RPag &P de &N');
        $exp->setEncBD($encBD);

        $exp->setEncabezados($encCol);
        $exp->setIfTotales(FALSE);

        $exp->exportar($datos);

        echo 'exportar';
    }

    /**
     * Metodo para editar los datos de un inmueble
     * @param Array $arg 
     * @access public
     */
    public function editarInscripcion($arg)
    {
        require_once DIRMODULOS . 'Inmuebles/Forms/EditarInscripcion.php';
        require_once LIBRERIAS . 'BarraHerramientas.php';
        /* traigo los siguientes campos de la lista de salones */
        $campos = array('salones.id, salones.salon');
        /* obtengo los datos de la bd */
        $this->_varForm['listaSalones'] = $this->_modeloSalones->listadoSalones(0, 'salon', '', $campos);
        /* Busco los datos de la inscripcion */
        $inscripcionBuscada = $this->_modelo->buscarInscripto($arg);
        if (is_object($inscripcionBuscada)) {
            $this->_varForm['id'] = $inscripcionBuscada->id;
            /* Si encontró la inscripcion busco los datos del inmueble */
            $inmuebleBuscado = $this->_modelo->buscarAlumno(array('id=' . $inscripcionBuscada->idAlumno));
            if (is_object($inmuebleBuscado)) {
                $this->_varForm['idAlumno'] = $inmuebleBuscado->id;
                $this->_varForm['apellidos'] = $inmuebleBuscado->apellidos;
                $this->_varForm['nombres'] = $inmuebleBuscado->nombres;
            } else {
                die('No se encontró al inmueble');
            }
            /* Si encontró la inscripcion busco los datos del salón */
            $salonBuscado = $this->_modeloSalones->buscarSalon(array('id=' . $inscripcionBuscada->idSalon));
            if (is_object($salonBuscado)) {
                $this->_varForm['idSalon'] = $inscripcionBuscada->idSalon;
                $this->_varForm['salon'] = $salonBuscado->salon;
            } else {
                die('No se encontró los datos del salón');
            }
            $this->_varForm['aLectivo'] = $inscripcionBuscada->aLectivo;
        } else {
            die('No se encontraron los datos de Inscripción');
        }
        $this->_form = new Form_EditarInscripcion($this->_varForm);
        $this->_vista->form = $this->_form->mostrar();
        if ($_POST) {
            if ($this->_form->isValid($_POST)) {
                $values = $this->_form->getValidValues($_POST);
                $valores['id'] = $values['id'];
                $valores['idSalon'] = $values['idSalon'];
                $valores['idAlumno'] = $values['idAlumno'];
                $valores['aLectivo'] = $values['aLectivo'];
                $condicion = implode(',', $arg);
                $this->_modelo->actualizarInscripcion($valores, $condicion);
                $this->_vista->mensajes = Mensajes::presentarMensaje(DATOSGUARDADOS, 'info');
            }
        }
        $bh = new BarraHerramientas($this->_vista);
        $bh->addBoton('Guardar', $this->_paramBotonGuardarAlumno);
        $bh->addBoton('Nuevo', $this->_paramBotonNuevaInscripcion);
        $bh->addBoton('Eliminar', array('href' => 'index.php?option=inmuebles&sub=eliminarInscripcion&id=' . $this->_varForm['id']
        ));
        $bh->addBoton('Lista', $this->_paramBotonListaInscriptos);
        $bh->addBoton('Volver', $this->_paramBotonVolver);

        $this->_vista->barraherramientas = $bh->render();
        $this->_layout->content = $this->_vista->render('AgregarInmueblesVista.php');
        // render final layout
        echo $this->_layout->render();
    }

}
