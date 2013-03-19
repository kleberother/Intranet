<?php 

//Instancia Classe
$connORA            =   "ora";               

$objORA             =   new models_T0084($connORA);

$dados   =   $objORA->retornaDadosFornecedor($codigo);

while ($row_ora = oci_fetch_assoc($dados))
{
    print_r($row_ora);
    echo "<br/>";
}
?>
