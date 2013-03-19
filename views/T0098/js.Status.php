<?php

$obj    =   new models_T0098();

$codigoCertificado  =   $_GET['codigoCertificado'];
$statusCertificado  =   $_GET['statusCertificado'];

$tabela =   "T108_conferencia_ge";

$count  =   $obj->retornaT108($codigoCertificado);

if ($count==0)
{
    $campos =   array("T108_codigo"     => $codigoCertificado
                     ,"T108_conferido"  => $statusCertificado
                     );
    
    $inseri =    $obj->inserir($tabela, $campos);
    
    if ($inseri)
        echo "Insere 1";
    else
        echo "Insere 0";    
}
else
{
    $campos = array ("T108_conferido"  => $statusCertificado);  
    
    $delim  = " T108_codigo  = $codigoCertificado";
    
    $altera =   $obj->altera($tabela, $campos, $delim);
    
    if($altera)
        echo "Altera 1";
    else
        echo "Altera 0";
}


?>