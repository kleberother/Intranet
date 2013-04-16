<?php 
//Instancia Classe
$obj        =   new models_T0026();

$lojaOrigem       =   $_REQUEST['lojaOrigem'];
$lojaDestino      =   $_REQUEST['lojaDestino'];

$dadosKm  =   $obj->retornaKm($lojaOrigem, $lojaDestino);


foreach($dadosKm  as  $campos =>  $valores)
{
    echo    $valores['Km'];
}

?>