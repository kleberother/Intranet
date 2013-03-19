<?php

$obj    = new models_T0095();

$codigoAuditoria    =   $_POST["codigoAuditoria"];
$codigoItem         =   $_POST["codigoRMS"];
$status             =   $_POST["status"];



$retornaPerfil = $obj->retornaPerfil($_SESSION['user']);

foreach ($retornaPerfil as $campo => $valores) {

    $perfil =   $valores["PERFIL"];
    
    echo $valores["PERFIL"]; 
    
}



if($perfil == 56){
    
    $tabela =   "T094_auditoria_detalhes";
    $campos =   array("T094_status_inv"     =>      "$status");
    $delim  =   "    T093_codigo          =   $codigoAuditoria ";
    $delim  .=  "AND T094_item_pai_rms    =   $codigoItem     ";
    
    
    $obj->altera($tabela, $campos, $delim);
    
} else {
    
    $tabela =   "T094_auditoria_detalhes";
    $campos =   array("T094_status_ge"     =>      "$status");
    
    $delim  =   "    T093_codigo        =   $codigoAuditoria ";
    $delim  .=  "AND T094_item_pai_rms    =   $codigoItem     ";
    
    
    $obj->altera($tabela, $campos, $delim);
    
}


?>
