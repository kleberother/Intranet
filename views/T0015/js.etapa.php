<?php 
//Retorno para js com a última etapa.

$obj    =   new models_T0015();

$etapa =   $obj->retornaUltimaEtapa();

$i  =   0;
foreach($etapa as $campos => $valores)
{
    $Option[$i] =   "<option value='".$valores['GrupoCodigo']."'>".$obj->preencheZero("E", 3, $valores['GrupoCodigo'])."-".$valores['GrupoNome']."</option>";
    $i++;
}

echo json_encode($Option);

?>