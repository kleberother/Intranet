<<<<<<< HEAD
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
$obj    =   new models_T0117();    

$tabela1    =   "T004_T113 ";
$delim1     =   "T113_codigo = ".$_GET["codRM"];

$del1   =   $obj->excluir($tabela1, $delim1);

if($del1){
$tabela = "T113_requisicao_mudanca";
$delim = "T113_codigo = ".$_GET["codRM"];


$obj->excluir($tabela, $delim);

}

?>
=======
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
$obj    =   new models_T0117();    

$tabela1    =   "T004_T113 ";
$delim1     =   "T113_codigo = ".$_GET["codRM"];

$del1   =   $obj->excluir($tabela1, $delim1);

if($del1){
$tabela = "T113_requisicao_mudanca";
$delim = "T113_codigo = ".$_GET["codRM"];


$obj->excluir($tabela, $delim);

}

?>
>>>>>>> 148f36d03329d248606ec6adce731e4b3d6c3ee5
