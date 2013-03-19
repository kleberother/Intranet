<?php

$tabela     =   $_GET['tabela'];
$etapa      =   $_GET['etapa'];
$campo      =   $_GET['campo'];
$codAP      =   $_GET['valor'];
$data       =   date('d/m/Y H:i:s');
//echo $data;
$user       =   $_SESSION['user'];
$status     =   $_GET['status'];

//INSTANCIA CLASSE
$objCancela   =   new models_T0016($conn);

$campos = array("T008_status" => "4");
$delim = "T008_codigo = ". $codAP;

$objCancela->altera($tabela, $campos, $delim);


?>