<?php

$retorno = "<div id=\"encabezado\">\n";
$retorno.= "<div class=\"fila1col\">\n";
$retorno.= "<h1><a href=\"" . LIVESITE . "index.php\" class=\"NombreSitio\">" . SITENAME . "</a></h1>\n";
$retorno.= "<h2 class=\"SloganSitio\">" . SITEDESCRIPTION . "</h2>\n";
$sesion = new Zend_Session_Namespace('didaskalos');

if (isset($sesion->MM_Nombre)) {
    $retorno.= "<div class=\"saludo\">Hola ";
    $retorno.= '<img src="' . IMG . 'usuarios/id' . $sesion->MM_UserId . '.png" class="foto_usuario_16" "> ';
    $retorno.= $sesion->MM_Nombre . "</div>\n";
    $retorno.= "<div class=\"logout\"><a href=\"" . LIVESITE . "/index.php?option=login&sub=logout\"> Salir </a></div>\n";
}

$retorno.= "<div class=\"fecha\"><script language=\"JavaScript\">fecha()</script></div>\n";
$retorno.= "</div>\n";
$retorno.= "</div>\n";

echo $retorno;