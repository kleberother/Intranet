<?php

$obj=   new models_REQUESTS();

$cpf=   $obj->retiraMascara($_GET['campocpf']);

$retorno = $obj->validaCPF($cpf);

echo $retorno;

   
?>
