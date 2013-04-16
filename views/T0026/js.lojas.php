<?php 
//Instancia Classe
$obj        =   new models_T0026();

$loja       =   $_REQUEST['loja'];

$dadosLoja  =   $obj->retornaLojas($loja);

$i          =   0;
$htmlLojas  =   "<option value=''>Selecione...</option>";
foreach($dadosLoja  as  $campos =>  $valores)
{
    $codigoLoja =   $obj->preencheZero("E", 3, $valores['LojaCodigo']);
    $nomeLoja   =   $valores['LojaNome'];
    $strLoja    =   $codigoLoja."-".$nomeLoja;
    
    $htmlLojas .=   "<option value='$codigoLoja'>$strLoja</option>";
    
    $i++;
}

echo $htmlLojas;

?>