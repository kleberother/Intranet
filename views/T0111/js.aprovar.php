<?php 
//Para aprovação de um item
//$Parametros =   $_REQUEST['parametros'] ;
//$i  =   0;
//if (!is_array($Parametros))
//{
//    $Parametros =   split(";",$Parametros)  ;
//    foreach($Parametros as $valores)
//    {
//        $valores            =   split(":",$valores) ;
//        $campo[$i][$valores[0]] =   $valores[1]         ;
//    }    
//}
////Para várias aprovações
//else
//{
//    foreach($Parametros as  $campos)
//    {
//        $campos =   split(";",$campos)  ;
//        foreach($campos as  $valores)
//        {
//            $valores            =   split(":",$valores) ;
//            $campo[$i][$valores[0]] =   $valores[1]     ;
//                                                    
//        }
//        
//        $i++;
//    }
//}



//Instancia Classe
$obj        =   new models_T0111()      ;

$QtdeCampos  =  count($campo)-1             ;
$data        =  date('d/m/Y H:i:s')         ;
$RemoteADDR  =  $_SERVER['REMOTE_ADDR']     ;
$RequestTime =  $_SERVER['REQUEST_TIME']    ;
$RequestUri  =  $_SERVER['REQUEST_URI']     ;
$user        =  $_SESSION['user']           ;

for($i=0;$i<=$QtdeCampos;$i++)
{
    // Parametros
    $AjusteCodigo[$i]     =  $_POST["T106_codigo"]; //$campo[$i]['AjusteCodigo'] ;
    $EtapaCodigo[$i]    =   $_POST["EtapaCodigo"];//$campo[$i]['EtapaCodigo'];
    
    //Altera status T016_T060
    $tabela =   "T106_T060"                                                                     ;
    $delim  =   "T106_codigo = ". $AjusteCodigo[$i] ." AND T060_codigo = ". $EtapaCodigo[$i]   ;
    $campos = array(
                        "T106_T060_status"          =>  1
                   ,    "T106_T060_dt_aprovacao"    =>  $data
                   ,    "T004_login"                =>  $user
                   ,    "T106_T060_REMOTE_ADDR"     =>  $RemoteADDR
                   ,    "T106_T060_REQUEST_TIME"    =>  $RequestTime
                   ,    "T106_T060_REQUEST_URI"     =>  $RequestUri
                   );

    $obj->altera($tabela, $campos, $delim);
    
    //Verifica se está aprovando a ultima etapa da Despesa
    $UltimaEtapa = $obj->retornaUltimaEtapaAjuste($AjusteCodigo[$i]);
    
    foreach($UltimaEtapa as $cp=>$vl)
    {        
        $UltimaEtapaCodigo = $vl['UltimaEtapa'];
    }
    
    if($EtapaCodigo[$i] == $UltimaEtapaCodigo)
        //Marca Despesa como finalizada
        $StatusAjuste = 9;
    else
        //Deixa Despesa apenas como aprovada
        $StatusAjuste = 1;
    
    //Altera status Despesa para 1
    $tabela = "T106_ajustes_ems";
    $campos = array( "T106_status"   =>  $StatusAjuste
                    ,"T106_func_conf" => $user);
    $delim = "T106_codigo = ".$AjusteCodigo[$i];

    $obj->altera($tabela, $campos, $delim);
    
    
    
}
?>