<?php

$obj = new models_T0095();
$auditoria = $_POST["codigoAuditoria"];

//$auditoria = "51225";



$a = 0;
$retornaConfirmados = $obj->retornaStatusItens($auditoria);
foreach ($retornaConfirmados as $cps => $valoresStatus) {
    $a++;
}

if ($a == 0) {

    $retornaGerentes = $obj->retornaGerentes($valoresStatus["T006_codigo"]);

    foreach ($retornaGerentes as $cpsGer => $valoresGer) {

        $retornaContato = $obj->retornaContatos($valoresGer["Usuario"]);

        foreach ($retornaContato as $cpsCont => $valoresCont) {

            $from        = "web@davo.com.br";
            $headers     = "From: $from\r\n";
            $headers    .= "Content-type: text/html\r\n";
            $para        = $valoresCont["Usuario"]."@davo.com.br";  
            $headers    .= "Cc: web@davo.com.br"; 
          //  $para        = "rsnascim@davo.com.br";  

            $texto = "Rupturas pendentes para confirmacao. Auditoria - $auditoria.";
            
            mail($para, "Rupturas (teste)", $texto, $headers);
            
            
        }
    }
    // echo "oi";
}
?>
