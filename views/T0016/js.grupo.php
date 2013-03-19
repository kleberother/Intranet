<?php
$objGrupo   =   new models_T0016($conn);

$loja       =   $_GET['loja'];
$processo   =   $_GET['processo'];
$grupo      =   $_GET['grupo'];
$forn       =   $_GET['forn'];
$tabela     =   "T026_T059";

$forn       =   $objGrupo->retiraMascara($forn);
$forn       =   $objGrupo->preencheZero("E", 14, $forn);

$Forn       =   $objGrupo->selecionaForn($forn);

foreach($Forn   as  $campos=>$valores)
{
    $codForn    =   $valores['COD'];
}

$arrAssocGrp    =   array( "T006_codigo" => $loja
                         , "T061_codigo" => $processo
                         , "T059_codigo" => $grupo
                         , "T026_codigo" => $codForn);

$inseri = $objGrupo->inserir($tabela, $arrAssocGrp);

?>