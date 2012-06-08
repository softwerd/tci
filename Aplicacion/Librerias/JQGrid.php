<?php

class JQGrid
{

    /**
     * Propiedad que indica el título de la grilla
     * @var type string
     */
    private $_caption;
    /**
     * Propiedad que indica el id de la tabla. Ej.: #grilla
     * @var type string
     */
    private $_idTable;
    /**
     * Propiedad que indica el nombre de las columnas.
     * El texto que aparece en el head de la grilla
     * @var type array
     */
    private $_colNames;
    /**
     * Propiedad que indica el formato de la columna
     * name es el nombre de la columna
     * index es el nombre pasado por el servidor para ordenar datos
     * width es el ancho de la columna
     * align es la alineacion de la columna (por defecto es izquierda)
     * sortable define si la columna puede ordenarse (por defecto true)
     * @var type array
     */
    private $_colModel;
    /**
     * Propiedad que indica la url donde obtiene los datos la grilla
     * @var type string
     */
    private $_url;
    private $_toolbar;
    private $_tb_ubicacion;
    private $_userdata;
    private $_footerrow;
    /**
     * Propiedad que indica la cantidad de filas por página.
     * Por defecto es 30
     * @var type integer
     */
    private $_rows = 30;
    private $_export;
    /**
     * Propiedad que indica si debe hacer algo al hacer doble clic
     * @var type boolean
     */
    private $_ondblClickRow = false;
    /**
     * Propiedad que indica que debe hacer al hacer doble clic
     * @var type string
     */
    private $_actionOnDblClickRow;
    /**
     * Propiedad que indica tipo de datos que recibe la grilla
     * del servidor
     * @var type string
     */
    private $_tipodatos ='json';
    /**
     * Propiedad que indica si debe mostrarse el botón de edición en el pie de pag.
     * @var type boolean
     */
    private $_ifBotonEditar = true;
    /**
     * Propiedad que indica si debe mostrarse el botón de eliminar en el pie de pag.
     * @var type boolean
     */
    private $_ifBotonEliminar = true;
    private $_ifBotonBuscar = true;
    private $_cellEdit;
    private $_datosLocal;
    
    /**
     * Establece si debe mostrarse el botón eliminar en el pie de pag.
     * @param type $ifBotonBuscar booleam
     */
    public function setIfBotonBuscar($ifBotonBuscar)
    {
        $this->_ifBotonBuscar = $ifBotonBuscar;
    }

    /**
     * Establece si debe mostrarse el botón eliminar en el pie de pag.
     * @param type $ifBotonEditar boolean
     */
    public function setIfBotonEliminar($ifBotonEliminar)
    {
        $this->_ifBotonEliminar = $ifBotonEliminar;
    }
    /**
     * Establece si debe mostrarse el botón editar en el pie de pag.
     * @param type $ifBotonEditar 
     */
    public function setIfBotonEditar($ifBotonEditar)
    {
        $this->_ifBotonEditar = $ifBotonEditar;
    }
    /**
     * Establece el título de la grilla
     * @param type $titulo string
     */
    public function setTitulo($titulo)
    {
        $this->_caption = $titulo;
    }

    /**
     * Establece el nombre de las columnas. El texto que aparece en el head de la grilla
     * @param type $colnames array
     */
    public function setColNames($colnames)
    {
        if (is_array($colnames)){
            $this->_colNames = implode(',', $colnames);
        }else{
            if(is_string($colnames) AND $colnames != ''){
                $this->_colNames = $colnames;
            }else{
                require_once 'Zend/Exception.php';
                throw new Zend_Exception('ColNames: Tipo de dato inválido');
            }
        }
    }

    /**
     * Establece el formato de las columnas
     * @param type $colmodel array
     */
    public function setColModel($colmodel)
    {
        $retorno = '';
         if (is_array($colmodel)){
             foreach ($colmodel as $row) {
                 $retorno[] = '{' . $this->_rowModel($row) .'}';
             }
             $this->_colModel = implode(',', $retorno);
         }
    }
    
    private function _rowModel($row)
    {
        foreach ($row as $key => $value){
            switch ($key) {
                case 'name':
                case 'index':
                case 'formatter':
                    $retornoFila[]= $key . ':' . "'". $value . "'";
                    break;
                case 'width':
                    $retornoFila[]= $key . ':' . $value;
                    break;
                case 'align':
                    $retornoFila[]= $key . ':"' . $value . '"';
                    break;
                case 'formatoptions':
                    foreach ($value as $clave => $valor){
                        $regreso[]= $clave . ':' . '"' . $valor . '"';
                    }
                    $retornoFila[] = $key . ':' . '{' . implode(',', $regreso) .'}';
                    break;
                default:
                    break;
            }
        }
        return implode(',', $retornoFila);
    }

    /**
     * Establece la url de donde obtiene los datos la grilla
     * @param type $url string
     */
    public function setUrl($url)
    {
        $this->_url = $url;
    }

    public function setFooterrow($footerrow)
    {
        $this->_footerrow = $footerrow;
    }

    public function setToolbar($toolbar, $posicion)
    {
        $this->_toolbar = $toolbar;
        $this->_tb_ubicacion = $posicion;
    }

    public function setUserdata($data)
    {
        $this->_userdata = $data;
    }

    /**
     * Establece la cantidad de filas por página que se ven
     * @param type $rows integer
     */
    public function setRows($rows)
    {
        $this->_rows = $rows;
    }

    public function setExport($export)
    {
        $this->_export = $export;
    }

    /**
     * Establece si debe hacer algo cuando hace doble clic
     * @param type boolean 
     */
    public function setOnDblClickRow($ondblClickRow=false)
    {
        $this->_ondblClickRow = $ondblClickRow;
    }
    
    /**
     * Establece que debe hacer cuando hace doble clic en la fila
     * @param type $action string
     */
    public function setActionOnDblClickRow($action)
    {
        $this->_actionOnDblClickRow = $action;
    }

    /**
     * Establece el formato de datos que recibe la grilla del servidor
     * @param type $tipo string
     */
    public function setTipoDatos($tipo='json')
    {
        $this->_tipodatos = $tipo;
    }

    public function setCellEdit($val=false)
    {
        $this->_cellEdit = $val;
    }

    public function setDatosLocal($datosLocal)
    {
        $this->_datosLocal = $datosLocal;
    }

    function __construct($idTable)
    {
        $this->_idTable = $idTable;
    }

    public function incluirJs()
    {
        $retorno = "<script type=\"text/javascript\">\n";
        // We use a document ready jquery function.
        $retorno.="jQuery(document).ready(function(){\n";
        $retorno.="jQuery(\"#" . $this->_idTable . "\").jqGrid({\n";
        // the url parameter tells from where to get the data from server adding ?nd='+new Date().getTime() prevent IE caching
        if ($this->_url != '' & $this->_tipodatos != 'local') {
            $retorno.="url:'" . $this->_url . "',\n";
        }
        if ($this->_caption != '') {
            $retorno.= "caption:'" . $this->_caption . "',\n";
        }
        if ($this->_cellEdit == 'SI') {
            $retorno.= "cellEdit: true,\n";
            $retorno.= "cellsubmit: 'remote',\n";
            $retorno.= "cellurl: '" . LIVESITE . "/ajaxturnos.php?id=5" . "',\n";
            $retorno.= "afterSaveCell : alert('se guardo'),\n";
        }
        $retorno.="height: 400,\n";
        // datatype parameter defines the format of data returned from the server in this case we use a JSON data
        $retorno.="datatype: \"" . $this->_tipodatos . "\",\n";
        // colNames parameter is a array in which we describe the names in the columns. This is the text that apper in the head of the grid.
        $retorno.="colNames:[" . $this->_colNames . "],\n";
        // colModel array describes the model of the column.
        // name is the name of the column, index is the name passed to the server to sort data
        // note that we can pass here nubers too. width is the width of the column
        // align is the align of the column (default is left) sortable defines if this column can be sorted (default true)
        $retorno.="colModel:[\n";
        $retorno.= $this->_colModel;
        $retorno.="],\n";
        // rowNum parameter describes how many records we want to view in the grid. We use this in example.php to return
        // the needed data.
        $retorno.="rowNum:" . $this->_rows . ",\n";
        // rowList parameter construct a select box element in the pager in wich we can change the number of the visible rows
        $retorno.="rowList:[10,20,30],\n";
        // pager parameter define that we want to use a pager bar in this case this must be a valid html element.
        // note that the pager can have a position where you want
        $retorno.="pager: jQuery('#pager2'),\n";
        // sortname sets the initial sorting column. Can be a name or number. this parameter is added to the url
//    	$retorno.="sortname:'ID',\n";
        //viewrecords defines the view the total records from the query in the pager bar. The related tag is: records in xml or json definitions.
        $retorno.="viewrecords: true,\n";
        //sets the sorting order. Default is asc. This parameter is added to the url
        $retorno.="sortorder: \"desc\",\n";
        
        if ($this->_ondblClickRow){
            $retorno .= 'ondblClickRow: function(id){ location.href = "' . LIVESITE . $this->_actionOnDblClickRow . "\"+id" . ";}\n";
            //$retorno .= "ondblClickRow: function(id){ location.href = '" . LIVESITE . "/index.php?option=" . $this->_idTable . "&sub=detalle&id=' +id;},\n";
        } 
        
        if ($this->_toolbar == 'YES'){
                $retorno.= "toolbar: [true,\"" . $this->_tb_ubicacion . "\"],\n";
        }
//        if ($this->_userdata != '') {
//            $retorno .= "userdata: " . $this->_userdata . ",\n";
//            $retorno .= "loadComplete: function() {\n";
//            $retorno .= "var tig=jQuery(\"#" . $this->_idTable . "\").getGridParam('userdata');\n";
//            $retorno .= "$(\"#t_" . $this->_idTable . "\").css(\"text-align\",\"right\").html(\"Total Importe Gravado:$\" + tig.total_importe_gravado + \" - Total Iva:$\" + tig.total_iva + \"&nbsp;&nbsp;&nbsp;\")},\n";
//            $retorno .= "caption: \"" . $this->_caption . "\",\n";
//        }
//		if ($this->_footerrow == 'YES'){
//   	 		$retorno.= "footerrow: true,\n";
//   	 		$retorno.= "userDataOnFooter: true,\n";
//   	 		$retorno.= "altRows: true \n";
//		}
//		$retorno.="editurl:\"someurl.php\"\n"; 
        $retorno.="});\n";

        $retorno .= "$(\"#" . $this->_idTable . "\").jqGrid('navGrid','#pager2',\n";
        $retorno .= "{";
        if ($this->_ifBotonEditar){
            $retorno .= "edit:true,";
        }else{
            $retorno .= "edit:false,";
        }
        if ($this->_ifBotonEliminar){
             $retorno .= "del:true,";
        }else{
             $retorno .= "del:false,";
        }
        if ($this->_ifBotonBuscar){
             $retorno .= "search:true,";
        }else{
             $retorno .= "search:false,";
        }
        $retorno .= "add:false,refresh:true,position:\"left\"})\n";    //options 
//		$retorno .= "{},\n";    // // add options 
//		$retorno .= "{width:400, url: 'bin/bin_oferta_borrado.php?q=1'},\n";   // del options  
//		$retorno .= "{width:900},\n";    //edit options 
//		$retorno .= "{width:600, multipleSearch : true},\n";    // search options 
//		$retorno .= "{closeOnEscape:true})\n";
//		if ($this->_export != ''){
//		    $retorno .= ".jqGrid('navButtonAdd','#pager2',{caption:\"\",title:\"Export\",buttonicon:\"ui-icon-disk\",onClickButton:function(){\n";
//		    $retorno .= " window.location.href = \"" . $this->_export . "\";	}});\n";
//		}
//		
//		if ($this->_tipodatos == 'clientSide'){
//		    $retorno .= "var myfirstrow = {hora:\"14:00\", lunes:\"\", martes:\"\", miercoles:\"\", jueves:\"NO\", viernes:\"\"};\n";
//            $retorno .= "$(\"#" . $this->_idTable . "\").addRowData(\"1\", myfirstrow);\n";
//		}
//		if ($this->_tipodatos == 'local'){
//		    $retorno .= "var mydata = $this->_datosLocal";
//		    $retorno .= "for(var i=0;i<=mydata.length;i++) jQuery(\"#list4\").jqGrid('addRowData',i+1,mydata[i]);"; 
//		}


        /* 		//Código para borrar desde un link o botón que tenga como id "borrar"		
          $retorno .= "$(\"#borrar\").click( function(){\n";
          $retorno .= "var idr = jQuery(\"#" . $this->_idTable . "\").jqGrid('getGridParam','selrow');\n";
          $retorno .= "if (idr != null ) jQuery(\"#" . $this->_idTable . "\").jqGrid('delGridRow',idr,{reloadAfterSubmit:false});\n";
          $retorno .= "else alert(\"Please Select Row to delete!\");\n";
          $retorno .= "});\n"; */

        /* 		Esto es para exportar la grilla
         * 		jQuery("#grid_id").jqGridExport(options);
         */

        $retorno.="});\n";
        $retorno.="</script>\n";
        return $retorno;
    }

}

