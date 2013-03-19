<?php

$obj = new models_T0111();

$t106_codigo = $_GET['cod'];
$user = $_SESSION['user'];
$status = $_GET['status'];
$filtros = $_GET['filtro'];

$data = date('d/m/Y');
$data_inc = date('Y-m-d');

$data        =  date('d/m/Y H:i:s')         ;
$RemoteADDR  =  $_SERVER['REMOTE_ADDR']     ;
$RequestTime =  $_SERVER['REQUEST_TIME']    ;
$RequestUri  =  $_SERVER['REQUEST_URI']     ;
 $tabela =   "T106_T060"                    ;
 
    $delim  =   "T106_codigo = ". $_GET["cod"] ." AND T060_codigo = ". $_GET["etapa"]   ;
    $campos = array(
                        "T106_T060_status"          =>  1
                   ,    "T106_T060_dt_aprovacao"    =>  $data
                   ,    "T004_login"                =>  $user
                   ,    "T106_T060_REMOTE_ADDR"     =>  $RemoteADDR
                   ,    "T106_T060_REQUEST_TIME"    =>  $RequestTime
                   ,    "T106_T060_REQUEST_URI"     =>  $RequestUri
                   );
    $obj->altera($tabela, $campos, $delim);
//    //Verifica se está aprovando a ultima etapa da Despesa
    $UltimaEtapa = $obj->retornaUltimaEtapaAjuste($_GET["cod"]);
    
    foreach($UltimaEtapa as $cp=>$vl)
    {        
        $UltimaEtapaCodigo = $vl['UltimaEtapa'];
    }
    
    if($_GET["etapa"]  == $UltimaEtapaCodigo)
        //Marca Despesa como finalizada
        $StatusAjuste = 9;
    else
        //Deixa Despesa apenas como aprovada
        $StatusAjuste = 1;
    
    //Altera status Despesa para 1
    $tabela = "T106_ajustes_ems";
    $campos = array( "T106_status"   =>  $StatusAjuste
                    ,"T106_func_conf" => $user);
    $delim = "T106_codigo = ".$_GET["cod"];

    $obj->altera($tabela, $campos, $delim);
    
    
    


?>
