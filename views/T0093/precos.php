<?php

$obj    = new models_T0093();

$dadosIntra =   $obj->dadosintra();

$objORA    = new models_T0093('ora');

foreach($dadosIntra as $campos => $valores)
{
    
    $ean        =   $valores['Ean']     ;    
            
    $dadosRMS   =   $objORA->checkRMS($ean);
    
    while ($row_ora = oci_fetch_assoc($dadosRMS))
    {        
        
        $codigofornecedor   =   $row_ora['CODIGOFORNECEDOR'];
        

        // separa os campos do retorno em um array
//        $ArrayPrc = split(',',str_replace('|',',',$infoPreco));
//        
//        $precoVigente   =   $ArrayPrc[0]/100;
//        $precoOferta    =   $ArrayPrc[4]/100;
//        
//        if($precoOferta > 0)
//        {
//            $precoRMS   =   $precoOferta    ;
//            $oferta     =   'S'             ;
//        }
//        else
//        {
//            $precoRMS   =   $precoVigente   ;
//            $oferta     =   'N'             ;
//        }                          
        
        //$precoRMS       =   $obj->formataValor("T094_auditoria_detalhes","T094_preco_rms",$precoRMS);                                                                                            
        
    }
    
    $tabela =   "T094_auditoria_detalhes";
    
    $delim  =   " T094_EAN =   $ean";
    
    
    $campos =   array(  "T094_fornecedor_rms"    =>  $codigofornecedor);
    
    $obj->altera($tabela, $campos, $delim);
    
}
?>