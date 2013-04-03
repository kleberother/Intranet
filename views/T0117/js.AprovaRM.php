<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 27/03/2013 Roberta Schimidt    
 * Descrição: Incluir Executores RM
 * Entradas:   
 * Origens:   
           
**************************************************************************
*/

$conn   = "";
$obj    = new models_T0117();


$codRM  =   $_REQUEST["codRM"];

$tabela =   "T113_requisicao_mudanca";

$campos =   array("T113_status" => 5);
$delim  =   "T113_codigo = ".$codRM;

$obj->altera($tabela, $campos, $delim);
        
        
?>
