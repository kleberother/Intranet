<?php

$obj = new models_T0111();

$retornaMotivo = $obj->retornaMotivo($_GET["cod"]);

foreach ($retornaMotivo as $key=>$value)
{
    echo $value["MOTIVO"];
}

?>
