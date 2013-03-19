<?php

$obj=   new models_T0111();

$cpf=   $obj->retiraMascara($_GET['campocpf']);

if (strlen($cpf)==11)
    echo 1;
else
    echo 0;


?>