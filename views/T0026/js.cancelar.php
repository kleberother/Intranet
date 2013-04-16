<?php

//INSTANCIA CLASSE
$obj    =   new models_T0026();

$codigoDespesa  =   $_REQUEST['codigoDespesa'];

$tabela =   "T016_despesa";
$campos = array("T016_status" => "4");

$delim = "T016_codigo = ". $codigoDespesa;

$cancelaDespesa =   $obj->altera($tabela, $campos, $delim);

if($cancelaDespesa)
    echo 1;
else
    echo 0;

?>