<?php 
//Para aprovação de um item
$Parametros =   $_REQUEST['parametros'] ;
$i  =   0;
if (!is_array($Parametros))
{
    $Parametros =   split(";",$Parametros)  ;
    foreach($Parametros as $valores)
    {
        $valores            =   split(":",$valores) ;
        $campo[$i][$valores[0]] =   $valores[1]         ;
    }    
}
//Para várias aprovações
else
{
    foreach($Parametros as  $campos)
    {
        $campos =   split(";",$campos)  ;
        foreach($campos as  $valores)
        {
            $valores            =   split(":",$valores) ;
            $campo[$i][$valores[0]] =   $valores[1]     ;
                                                    
        }
        
        $i++;
    }
}

//Instancia Classe
$obj        =   new models_T0084()      ;

$QtdeCampos  =  count($campo)-1             ;
$data        =  date('d/m/Y H:i:s')         ;
$RemoteADDR  =  $_SERVER['REMOTE_ADDR']     ;
$RequestTime =  $_SERVER['REQUEST_TIME']    ;
$RequestUri  =  $_SERVER['REQUEST_URI']     ;
$user        =  $_SESSION['user']           ;

for($i=0;$i<=$QtdeCampos;$i++)
{
    // Parametros
    $NotaCodigo[$i]     =   $campo[$i]['NotaCodigo'] ;
    $EtapaCodigo[$i]    =   $campo[$i]['EtapaCodigo'];
    
    //Altera status T016_T060
    $tabela =   "T013_T060"                                                                     ;
    $delim  =   "T013_codigo = ". $NotaCodigo[$i] ." AND T060_codigo = ". $EtapaCodigo[$i]   ;
    $campos = array(
                        "T013_T060_status"          =>  1
                   ,    "T013_T060_dt_aprovacao"    =>  $data
                   ,    "T004_login"                =>  $user
                   ,    "T013_T060_REMOTE_ADDR"     =>  $RemoteADDR
                   ,    "T013_T060_REQUEST_TIME"    =>  $RequestTime
                   ,    "T013_T060_REQUEST_URI"     =>  $RequestUri
                   );

    $obj->altera($tabela, $campos, $delim, false);
    
    //Verifica se está aprovando a ultima etapa da Despesa
    $UltimaEtapa = $obj->retornaUltimaEtapaNota($NotaCodigo[$i]);
    
    foreach($UltimaEtapa as $cp=>$vl)
    {        
        $UltimaEtapaCodigo = $vl['UltimaEtapa'];
    }
    
    if($EtapaCodigo[$i] == $UltimaEtapaCodigo)
        //Marca Despesa como finalizada
        $StatusNota = 9;
    else
        //Deixa Despesa apenas como aprovada
        $StatusNota = 1;
    
    //Altera status Despesa para 1
    $tabela = "T013_nota_debito";
    $campos = array("T013_status"   =>  $StatusNota);
    $delim = "T013_codigo = ".$NotaCodigo[$i];

    $obj->altera($tabela, $campos, $delim, false);
    
}
?>