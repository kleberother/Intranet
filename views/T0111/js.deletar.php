<?php

///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 06/08/2012 por Roberta Schimidt                               
// * Descrição: Ajustes EM$ - Deletar
// * Entrada:   
// * Origens:   
//           
//**************************************************************************

$conn = "";
$obj = new models_T0111();

$status = $_GET["status"];
$filtros = $_GET["filtros"];

$tabela1 = "T106_ajustes_ems";
$delim1 = "T106_codigo = ".$_GET["cod"];


$deletarTab1 = $obj->excluir($tabela1, $delim1);

$tabela2 = "T106_T060";
$delim2 = "T106_codigo =".$_GET["cod"];

$deletarTab2 = $obj->excluir($tabela2, $delim2);


?>