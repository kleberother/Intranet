<?php

$obj    = new models_T0095();

$codigoAuditoria    =   $_POST["codigoAuditoria"];
$status             =   $_POST["status"];

$retornaPerfil = $obj->retornaPerfil($_SESSION['user']);

foreach ($retornaPerfil as $campo => $valores) {

    $perfil =   $valores["PERFIL"];
    
    echo $valores["PERFIL"];
    
}



if($perfil == 56){
    
    $tabela =   "T093_auditoria";
    $campos =   array("T093_gerente"     =>      "$status");
    $delim  =   "    T093_codigo        =   $codigoAuditoria ";
    
    
    
    $obj->altera($tabela, $campos, $delim);
    
} else {
    
    $tabela =   "T093_auditoria"                                        ;
    $campos =   array("T093_inventario"     =>      "$status")          ;
    $delim  =   "      T093_codigo          =        $codigoAuditoria " ;
  
    
    
    $obj->altera($tabela, $campos, $delim);
    
}


?>

