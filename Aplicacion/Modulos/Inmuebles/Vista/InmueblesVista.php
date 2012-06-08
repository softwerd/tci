<?php

$retorno = "<div id=\"ventana\" class=\"window ui-widget-content ui-corner-all\">\n";
$retorno .= "<div class=\"toolbar\">\n";

$retorno .= '<div class="boton_central ui-widget-content ui-corner-all">';
$retorno .= "<a href=\"index.php?option=alumnos&sub=agregar\" target=\"_self\" title=\"Agregar Alumnos\">\n";
$retorno .= "<img src=\"" . DIR_MODULOS . "Alumnos/Vista/alumnos_add.png\" alt=\"Nuevo Cliente\" class=\"toolbar2\"/>Agregar Alumnos\n";
$retorno .= "</a></div>\n";

$retorno .= '<div class="boton_central ui-widget-content ui-corner-all">';
$retorno .= "<a href=\"index.php?option=alumnos&sub=listar\" target=\"_self\" title=\"Lista de Alumnos\">\n";
$retorno .= "<img src=\"" . DIR_MODULOS . "Alumnos/Vista/lista_alumnos.png\" alt=\"Lista de Alumnos\" class=\"toolbar2\"/>Lista de Alumnos\n";
$retorno .= "</a></div>\n";

$retorno .= '<div class="boton_central ui-widget-content ui-corner-all">';
$retorno .= "<a href=\"index.php?option=alumnos&sub=inscribir\" target=\"_self\" title=\"Inscribir Alumnos\">\n";
$retorno .= "<img src=\"" . DIR_MODULOS . "Alumnos/Vista/alumnos_inscripcion.png\" alt=\"Inscribir Alumno\" class=\"toolbar2\"/>Inscribir Alumnos\n";
$retorno .= "</a></div>\n";

$retorno .= '<div class="boton_central ui-widget-content ui-corner-all">';
$retorno .= "<a href=\"index.php?option=alumnos&sub=listarInscriptos\" target=\"_self\" title=\"Lista de Inscriptos\">\n";
$retorno .= "<img src=\"" . DIR_MODULOS . "Alumnos/Vista/lista_inscripcion.png\" alt=\"Lista de Inscriptos\" class=\"toolbar2\"/>Lista de Inscriptos\n";
$retorno .= "</a></div>\n";

$retorno .= '<div class="boton_central ui-widget-content ui-corner-all">';
$retorno .= "<a href=\"index.php\" target=\"_self\" title=\"Salir\">\n";
$retorno .= "<img src=\"" . IMG . "backward.png\" alt=\"Volver\" class=\"toolbar2\"/>Volver\n";
$retorno .= "</a></div>\n";
$retorno .= "</div>\n";
$retorno .= "</div>\n";
echo $retorno;
