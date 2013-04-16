<?php 
//Instancia Classe com Conexão Oracle
$obj    =   new models_T0026();

$tipo           =   $_REQUEST['tipo']                       ;    
$codigoDespesa  =   $_REQUEST['codigoDespesa']              ;    
$cpf            =   $obj->retiraMascara($_REQUEST['cpf'])   ;    
$data           =   $_REQUEST['data']                       ;    
$historico      =   $_REQUEST['historico']                  ;    
$lojaOrigem     =   $_REQUEST['lojaOrigem']                 ;    
$lojaDestino    =   $_REQUEST['lojaDestino']                ;    
$hrOrigem       =   $_REQUEST['hrOrigem']                   ;    
$hrDestino      =   $_REQUEST['hrDestino']                  ;       
$km             =   $_REQUEST['km']                         ;   
$totalDespKm    =   $_REQUEST['totalDespesa']               ;
if (empty($totalDespKm))
    $totalDespKm   =   0;

$totalDespDiv   =   $_REQUEST['totalDespesaDiv']            ;
if (empty($totalDespDiv))
    $totalDespDiv   =   0;

$totalGeral     =   $_REQUEST['totalGeral']                 ;   
$user           =   $_SESSION['user']                       ;
$dataElaboracao =   date("d/m/Y")                           ;
$valorDespDiv   =   $_REQUEST['valor']                      ;
$conta          =   $_REQUEST['conta']                      ;

$arrConta       =   explode("-",$conta)                     ;
$crf            =   $arrConta[0]                            ;

$dadosConta     =   $obj->retornaDadosConta($crf)           ;
foreach($dadosConta as $cp => $vl)
{
    $conta  =   $vl['CodigoConta'];
}

$arrOrig        =   explode("-",$lojaOrigem)                ;
$codigoOrig     =   $arrOrig[0]                             ;
$arrDest        =   explode("-",$lojaDestino)               ;
$codigoDest     =   $arrDest[0]                             ;

$strDataHoraOrig    =   $data." ".$hrOrigem.":00"           ;
$strDataHoraDest    =   $data." ".$hrDestino.":00"          ;

//Tipo = 1 Inseri Cabeçalho
if($tipo==1)
{
    $tabela =   "T016_despesa";
    
    $campos =   array(  "T016_cpf"                  =>  $cpf
                      , "T016_vl_total_geral"       =>  $totalGeral
                      , "T016_centro_custo_RMS"     =>  "0"
                      , "T004_login"                =>  $user
                      , "T016_status"               =>  0
                      , "T016_dt_elaboracao"        =>  $dataElaboracao
                    );
    
    $inseriDespesa  =   $obj->inserir($tabela, $campos);
    
    $codigoDespesa  =   $obj->lastInsertId();
    
    if($inseriDespesa)
    {
        $tabela = "T016_T060";

        $grpWkfUser =   $obj->retornaPrimeiroGrupoWkfUsuario($user);

        $Etapa      =   $obj->retornaEtapaGrupo($grpWkfUser);

        foreach($Etapa as $campos=>$valores)
        {
            $array = array ( "T060_codigo"          =>  $valores['EtapaCodigo']
                           , "T016_codigo"          =>  $codigoDespesa
                           , "T016_T060_ordem"      =>  1
                           , "T016_T060_status"     =>  0
                           , "T004_login"           =>  $user);
            
            $obj->inserir($tabela, $array);
            $obj->inserirFluxo($codigoDespesa, $valores['ProxEtapaCodigo'],2);
        }
        
        echo $codigoDespesa;
    }                    
    else
        echo 0;
                   
}
//Tipo = 2 Inseri e Atualiza Detalhes
if($tipo==2)
{
        
    $tabela =   "T015_T016";

    $campos =   array( 
                        "T016_codigo"           =>  $codigoDespesa
                      , "T015_T016_saida"       =>  $strDataHoraOrig
                      , "T015_T016_chegada"     =>  $strDataHoraDest
                      , "T015_T016_desc"        =>  $historico
                      , "T015_T016_origem"      =>  $lojaOrigem
                      , "T015_T016_destino"     =>  $lojaDestino
                      , "T015_T016_km"          =>  $km
                      , "T006_codigo_origem"    =>  $codigoOrig
                      , "T006_codigo_destino"   =>  $codigoDest
                     );

    $obj->inserir($tabela, $campos);
    
    $tabela =   "T016_despesa";
    $arrPedido   =   $obj->retornaArrayPeriodo($codigoDespesa);
    
    $campos =   array(
                        "T016_dt_inicio"            =>  $arrPedido['DataInicial']
                      , "T016_dt_final"             =>  $arrPedido['DataFinal']    
                      , "T016_vl_total_km"          =>  $totalDespKm    
                      , "T016_vl_total_diversos"    =>  $totalDespDiv  
                     );
    
    $delim  =   " T016_codigo   =   $codigoDespesa";
        
    $obj->altera($tabela, $campos, $delim, false);
    
}
//Despesa Diversas
if($tipo==3)
{
    $tabela =   "T017_despesa_detalhe";
    
    $campos =   array(  
                        "T016_codigo"   =>  $codigoDespesa
                      , "T017_data"     =>  $data
                      , "T017_valor"    =>  $valorDespDiv
                      , "T014_codigo"   =>  $conta
                     );
    
    $obj->inserir($tabela, $campos);
    
}


?>