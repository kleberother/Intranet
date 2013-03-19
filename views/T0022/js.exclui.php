<?php

//Instancia Classe
$obj    =   new models_T0022();

$tabela         =   "T073_pesquisas_postos_concorrentes";
$delimitador    =   "T073_id = ".$_REQUEST['ItemId'];

$obj->excluir($tabela, $delimitador);

?>
