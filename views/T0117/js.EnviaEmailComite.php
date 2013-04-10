<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 10/04/2013 Roberta Schimidt    
 * Descrição: Enviar E-mail Comitê
 * Entradas:   
 * Origens:   
           
**************************************************************************
*/
$obj = new models_T0117();

$membrosComite  =   $obj->retornaComite();

foreach ($membrosComite as $cpsCom => $valCom) {
    
$codRM  = $_POST["codRM"];

$html    =   $valCom['Nome'];
$html   .=   "Há disponível uma Requisição de Mundança para aprovação.<br>";
$html   .=   "Requisição Nº ".$codRM;

$obj->enviaEmailComite($html, $valCom["Email"]);

}




?>
