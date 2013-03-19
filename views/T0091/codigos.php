<?php

$obj    =   new models_T0091();

$dados  =   $obj->produtosIntranet();

$objORA =   new models_T0091("ora");

foreach($dados  as  $campos=>$valores)
{
    
    $dadosOra  =   $objORA->produtoRMS($valores['EAN']);
    
    while ($row_ora = oci_fetch_assoc($dadosOra))
    {
        $codigoInterno  =   $row_ora['EAN'] ;
    }
    
    $tabela =   "T094_auditoria_detalhes";
    
    $campos =   array("T094_codigo_rms"=>$codigoInterno);
    
    $delim  =   " T094_EAN  = ".$valores['EAN'];
    
    $obj->altera($tabela, $campos, $delim);
    
}



?>