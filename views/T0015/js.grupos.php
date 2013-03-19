<?php 

$obj    =   new models_T0015();

$codigoProcesso =   $_REQUEST['CodigoProcesso'];

$grupos =   $obj->retornaGrupos($codigoProcesso);

$i  =   0;
foreach($grupos as $campos => $valores)
{
    $Option[$i] =   "<option value='".$valores['GrupoCodigo']."'>".$obj->preencheZero("E", 3, $valores['GrupoCodigo'])."-".$valores['GrupoNome']."</option>";
    $i++;
}

echo json_encode($Option);

?>