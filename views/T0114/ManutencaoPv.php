<?php

/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 06/11/2012 por Roberta Schimidt                               
 * Descrição: Ranking Comissão - Pv
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/

$conn = "";
$obj = new models_T0114($conn);

$conn               =   "mssql";
$verificaConexao    =   "";
$db                 =   "DBO_CRE";
$objMSSQL = new models_T0114($conn,$verificaConexao,$db); // fim conexao

$connOra               =       "ora";
$objOra = new models_T0114($connOra);










?>
