<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 23/03/2011 por Rodrigo Alfieri                              */
/* Descrição: Classe que adiciona as classes necessarias para o 
 *         funcionamento do sistema automaticamente definindo o 
 *         local aonde elas se encontram.                                 */
/**************************************************************************/

function __autoload($class_name)
{
    require_once 'models/'.$class_name . '/'.$class_name . '.php';
    require_once 'controllers/'.$class_name . '/'.$class_name . '.php';
}
 
?>
