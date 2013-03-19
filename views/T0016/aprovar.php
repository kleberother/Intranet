<?php

$tabela      =  $_GET['tabela']             ;
$etapa       =  $_GET['etapa']              ;
$campo       =  $_GET['campo']              ;
$codAP       =  $_GET['valor']              ;
$data        =  date('d/m/Y H:i:s')         ;
$Aps         =  array ()                    ;
$Etapas      =  array ()                    ;
$RemoteADDR  =  $_SERVER['REMOTE_ADDR']     ;
$RequestTime =  $_SERVER['REQUEST_TIME']    ;
$RequestUri  =  $_SERVER['REQUEST_URI']     ;
//Para Tipo Despesa
$TpNota      =  $_GET['tpnota']             ;

//echo $data;
$user        =  $_SESSION['user']           ;
$status      =  $_GET['status']             ;

//INSTANCIA CLASSE
$objAprova   =   new models_T0016($conn);

$Aps    = split(',',$codAP);
$Etapas = split(',',$etapa);
$TpsNota = split(',',$TpNota);

$i=0;
foreach($Aps as $camposAP=>$valoresAP)
{    
    $EtapaAP    =   $Etapas[$i];
    $TpNotaAP   =   $TpsNota[$i];
    
    $campos = '';
    $delim  = '';
    //Altera status T008_T060
    $delim = "T008_codigo = $valoresAP AND T060_codigo = $EtapaAP";
    $campos = array(
                        "T008_T060_status"          =>  1
                   ,    "T008_T060_dt_aprovacao"    =>  $data
                   ,    "T004_login"                =>  $user
                   ,    "T008_T060_REMOTE_ADDR"     =>  $RemoteADDR
                   ,    "T008_T060_REQUEST_TIME"    =>  $RequestTime
                   ,    "T008_T060_REQUEST_URI"     =>  $RequestUri
                   );

    $objAprova->altera($tabela, $campos, $delim);
    
    
    //Verifica proxima etapa da Ap
    $dadosProxEtpAp =   $objAprova->retornaUltimaEtapaAprovadaAp($valoresAP);
    foreach($dadosProxEtpAp as $cp => $vl)
    {
        $ProxEtapa  =   $vl['ProxEtapa'];     
    }
    //Caso tipo de despesa = 2 e próxima etapa = 3 (Conferente de Impostos) Etapa será aprovada automaticamente    
    if (($TpNotaAP==2) && ($ProxEtapa==3))
    {
        $campos = '';
        $delim  = '';
        //Altera status T008_T060
        $delim = "T008_codigo = $valoresAP AND T060_codigo = $ProxEtapa";
        $campos = array(
                            "T008_T060_status"          =>  1
                       ,    "T008_T060_dt_aprovacao"    =>  $data
                       ,    "T004_login"                =>  $user
                       ,    "T008_T060_REMOTE_ADDR"     =>  $RemoteADDR
                       ,    "T008_T060_REQUEST_TIME"    =>  $RequestTime
                       ,    "T008_T060_REQUEST_URI"     =>  "[Aprovado Automaticamente] - ".$RequestUri
                       );
        
        $objAprova->altera($tabela, $campos, $delim);
    }
        
    //Verifica se está aprovando a ultima etapa da AP
    $UltimaEtapa = $objAprova->RetornaUltimaEtapaAP($valoresAP);
    
    foreach($UltimaEtapa as $campo=>$valor)
    {
        $UltimaEtapaCod = $valor['EtapaCodigo'];
    }
    
    if($EtapaAP == $UltimaEtapaCod)
    {
        //Marca AP como finalizada
        $StatusAP = 9;
    }
    else
    {   //Deixa AP apenas como aprovada
        $StatusAP = 1;
    }
    //Altera status AP para 1
    $tabelaT008 = "T008_approval";
    $campos = array("T008_status"   =>  $StatusAP);
    $delim = "T008_codigo = $valoresAP";

    $objAprova->altera($tabelaT008, $campos, $delim);
    /*
        if (!$objAprova)
            echo "1";
        else
            echo "2";
    */        
       $i++;
}
?>