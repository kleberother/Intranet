<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 18/04/2012 por Rodrigo Alfieri    
 * Descrição: Programa para retornar parametros da tabela
 * Entradas:  Parametro 
 * Saidas:    Valor
           
**************************************************************************
*/

$obj            =   new models_parametro()              ;

$nome           =   $_GET['Parametro']                  ;

$valorParametro =   $obj->retornaValorParametro($nome)  ;

echo $valorParametro[0];
?>
