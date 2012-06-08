<?php

class Mensajes
{
    public static function presentarMensaje($mensaje, $tipo)
    {
        $retorno = '';
        if (is_array($mensaje)){
            $mensaje = implode('<br>', $mensaje);
        }
        switch ($tipo){
            case 'info':
                        $retorno .= '<div class="infoM mensajes ui-corner-all"><p class="mensajes">' . $mensaje . '</p></div>';
                        break;
                case 'ok' :
                        $retorno .= '<div class="exitoM mensajes ui-corner-all">' . $mensaje . '</div>';
                        break;
                case 'alerta' :
                        $retorno .= '<div class="alertaM mensajes ui-corner-all">' . $mensaje . '</div>';
                        break;
                case 'error' :
                        $retorno .= '<div class="errorM mensajes ui-corner-all">' . $mensaje . '</div>';
                        break;
                default:
                    $retorno .= '<div class="errorM mensajes ui-corner-all">' . $mensaje . '</div>';
                    break;
        }
        return $retorno;
    }
}
