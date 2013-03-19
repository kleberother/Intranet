<?php

///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 12/03/2013 por Roberta Schimidt                               
// * Descrição: Areas de Negocio - Deletar
// * Entrada:   
// * Origens:   
//           
//**************************************************************************

$conn   =   "";
$obj    =   new models_T0116();    



$tabela = "T114_areas_negocio";
$delim = "T114_codigo = ".$_GET["codAN"];


$deletarTab = $obj->excluir($tabela, $delim);


?>
