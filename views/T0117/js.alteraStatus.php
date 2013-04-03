<?php

/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 03/04/2013 Roberta Schimidt    
 * Descrição: Incluir Executores RM
 * Entradas:   
 * Origens:   
           
**************************************************************************
*/

$conn   = "";
$obj    = new models_T0117();



$revisado   =    $_REQUEST["revisado"];
$codRM      =    $_REQUEST["codRM"];

if($revisado == 1){
    
   $tabela =   "T113_requisicao_mudanca";
   $campos =   array("T113_status" => 2);
   $delim  =   "T113_codigo    =   ".$codRM;
    
   $obj->altera($tabela, $campos, $delim);
}

?>
