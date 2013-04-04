<?php 
//Instancia Classe com Conexão Oracle
$obj    =   new models_T0026();

$tipo           =   $_REQUEST['tipo']           ;    
$data           =   $_REQUEST['data']           ;    
$historico      =   $_REQUEST['historico']      ;    
$lojaOrigem     =   $_REQUEST['lojaOrigem']     ;    
$lojaDestino    =   $_REQUEST['lojaDestino']    ;    
$hrOrigem       =   $_REQUEST['hrOrigem']       ;    
$hrDestino      =   $_REQUEST['hrDestino']      ;    
$km             =   $_REQUEST['km']             ;    

//Tipo = 1 Despesa com Km
if($tipo==1)
{
    $tabela =   "";
    
    $campos =   array(  "T016_vl_total_km"          =>  ""
                      , "T016_vl_total_diversos"    =>  ""
                      , "T016_vl_total_geral"       =>  ""
                      , "T016_centro_custo_RMS"     =>  ""
                      , "T004_login"                =>  ""
                      , "T016_status"               =>  ""
                      , "T016_dt_elaboracao"        =>  ""
                    );
    
    $obj->inserir($tabela, $campos);
    
    
}
//Despesa Diversas
else
{
    
}


?>