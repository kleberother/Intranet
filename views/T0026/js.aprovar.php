<?php

//INSTANCIA CLASSE
$obj        =   new models_T0026();

$codigoEtapa    =  $_REQUEST['codigoEtapa']         ;
$codigoDespesa  =  $_REQUEST['codigoDespesa']       ;
$data           =  date('d/m/Y H:i:s')              ;
$RemoteADDR     =  $_SERVER['REMOTE_ADDR']          ;
$RequestTime    =  $_SERVER['REQUEST_TIME']         ;
$RequestUri     =  $_SERVER['REQUEST_URI']          ;

$user           =  $_SESSION['user']                ;

$Despesas   = split(',',$codigoDespesa);
$Etapas     = split(',',$codigoEtapa);

$i=0;
foreach($Despesas as $campos    =>  $valores)
{    
    $tabela     =   "T016_T060";
    $Etapa      =   $Etapas[$i];
    
    //Altera status T016_T060
    $delim = "T016_codigo = $codigoDespesa AND T060_codigo = $Etapa";
    $campos = array(
                       "T016_T060_status"          =>  1
                     , "T016_T060_dt_aprovacao"    =>  $data
                     , "T004_login"                =>  $user
                     , "T016_T060_REMOTE_ADDR"     =>  $RemoteADDR
                     , "T016_T060_REQUEST_TIME"    =>  $RequestTime
                     , "T016_T060_REQUEST_URI"     =>  $RequestUri
                   );

    $alteraDespesa  =   $obj->altera($tabela, $campos, $delim);
        
    //Verifica se está aprovando a ultima etapa da AP
    $UltimaEtapa = $obj->retornaUltimaEtapaDespesa($valores);
    
    foreach($UltimaEtapa as $campo=>$valor)
    {
        $UltimaEtapaCod = $valor['EtapaCodigo'];
    }
    
    if($Etapa == $UltimaEtapaCod)
    {
        //Marca AP como finalizada
        $status = 9;
    }
    else
    {   //Deixa AP apenas como aprovada
        $status = 1;
    }
    //Altera status AP para 1
    $tabela = "T016_despesa";
    $campos = array("T016_status"   =>  $status);
    $delim = "T016_codigo = $valores";

    $obj->altera($tabela, $campos, $delim);
     
    if($alteraDespesa)
        $retorno    =   1;
    else
        $retorno    =   0;
    
    $i++;
}

echo $retorno;

?>