<?php

//Instancia Classe
$connORA            =   "ora";               

$objORA             =   new models_T0088($connORA);

// Faz o select de CRFs
$retornaCRF   =   $objORA->retornaCRFsORA();

while ($row_ora = oci_fetch_assoc($retornaCRF))
{
    print_r($row_ora);
    echo "<br/>";
}
?>
