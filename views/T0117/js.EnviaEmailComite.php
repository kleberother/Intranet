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
$nome   =   $valCom["Nome"];

        $to         = $valCom["Email"]; 
        $from       = "web@davo.com.br"; 
        $subject    = "Aviso de RM ao Comite";
        
        $html   =   $nome.'<br>';
        $html   .=   'Há uma Requisição de Mundança disponível para aprovação.<br>';
        $html   .=   'Requisição Nº '. $codRM;
    
        $headers  = "From: $from\r\n"; 
        $headers .= "Content-type: text/html\r\n"; 
        $headers .= "Cc: web@davo.com.br";
    
       
        
        mail($to, $subject, $html, $headers); 


}






?>
