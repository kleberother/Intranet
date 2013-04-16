<?php

//Instancia Classe
$conn      =   "emporium";
$objEMP    =   new models_T0119($conn);

$Lote      = $_REQUEST['Lote'];

$arrStatus = array("aprovacao_status_id"=>1,"aprovacao_data"=>date("%d/%m/%Y"));
$Tabela    = "davo_ccu_lote";
$Delim     = "lote_numero=$Lote AND store_key=2";

echo $Retorno   = $objEMP->altera($Tabela, $arrStatus, $Delim) ;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
