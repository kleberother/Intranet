<?php

// Objeto de Conexão
$obj = new models_T0010();

$Busca    = $obj->buscaUsuarioSemEmail();

foreach($Busca as $campos=>$valores)
{
    echo $valores['Login'];
}




?>

