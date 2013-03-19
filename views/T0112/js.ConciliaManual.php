<?php
///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 19/10/2012 por Alexandre Alves
// * Descrição: Programa de Conciliacao Correspondente Bancario (COBAN)
// * Entrada:   
// * Origens:   
//           
//**************************************************************************


//Instancia Classe
$obj       =   new models_T0112();
$conn      =   "ora";
$objORA    =   new models_T0112($conn);

$user           =   $_SESSION['user'];

 $Loja         = $_GET["Loja"];
 $PDV          = $_GET["PDV"];
 $Sequencial   = $_GET["Sequencial"];
 $CodTransacao = $_GET["CodTransacao"];
 $Data         = $_GET["Data"];  
 $Valor        = $_GET["Valor"]; 
 

echo $StatusConciliacao     =   $objORA->conciliacaoManual ($Loja,$PDV,$Sequencial,$CodTransacao,$Data,$Valor);

?>
