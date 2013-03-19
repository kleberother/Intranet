<?php

$obj = new models_T0111();

$retornaLojaUsu = $obj->retornaLojas($_SESSION['$user']);

$user = $_SESSION['$user'];
$dataIn = date("d/m/Y");


 

foreach($retornaLojaUsu as $campos=>$valores)
{
    $codigoLoja     =   $valores['Codigo'];
}


$retornaGrupos  =   $obj->retornaGruposWF($_SESSION['user']);


foreach($retornaGrupos as $campos=>$valores)
{

    $codigoWF   =   $valores['Codigo'];
    
}

if (!empty($_POST))
{
    
    $tabela_106         =       "T106_ajustes_ems";
    
    $tabela_089         =       "T089_parametro_detalhe";
    
    $tabela106060     =       "T106_T060"; 
    

    //Campos para inserir na tabela T106_ajustes_ems
    
    if (!empty($_POST['T106_qtd_parc'])){
        
        if(empty($_POST["T106_st_ajuste"])){
            
            $_POST["T106_st_ajuste"] = '0';
            
        }
        
        if($_POST['T106_tip_operacao'] == "ESCP" ) {
            
            $_POST['T106_valor_tot'] = "-".$_POST['T106_valor_tot'];
        }
        
        if(empty($_POST['T106_pdv'])){
            $_POST['T106_pdv'] = '0';
        }
        
        $lojaIn = $_POST["T006_codigo"];
        
 $camposT106     =       array( "T106_data_operacao"     => $_POST['T106_data_operacao']
                                 , "T107_codigo"      => $_POST['T106_tip_operacao']
                                 , "T106_conta"             => $_POST['T106_conta']
                                 , "T106_status"            => "0"
                                 , "T106_cpf"               => $_POST['T106_cpf']
                                 , "T106_valor_vista"       => $_POST['T106_valor_vista']
                                 , "T106_qtd_parc"          => $_POST['T106_qtd_parc']
                                 , "T106_valor_par"         => $_POST['T106_valor_par']
                                 , "T106_valor_tot"         => $_POST['T106_valor_tot']
                                 , "T106_n_cupom"           => $_POST['T106_n_cupom']
                                 , "T106_pdv"               => $_POST['T106_pdv']
                                 , "T106_func_libe"         => $_POST['T106_func_libe']
                                 , "T004_login    "         => $_SESSION['user']
                                 , "T106_dat_lanc"          => $dataIn
                                 , "T006_codigo"            => $lojaIn
                                 , "T106_motivo"            => $_POST['T106_motivo']    
                                 , "T106_justificativa"     => $_POST['T106_justificativa']
                                 , "T106_instrucoes"        => $_POST['T106_instrucoes']
                                 , "T106_st_ajuste"         => $_POST["T106_st_ajuste"]
                                             
                                    );  
    
   } else {
       
       $lojaIn = $_POST["T006_codigo2"];
       
           if(empty($_POST["T106_st_ajuste2"])){
            
            $_POST["T106_st_ajuste2"] = '0';
            
        }
        
        
     
         if(empty($_POST['T106_pdv2'])){
            $_POST['T106_pdv2'] = '0';
        }
        
       
       
   $camposT106     =       array( "T106_data_operacao"      => $_POST['T106_data_operacao2']
                                 , "T107_codigo"            => $_POST['T106_tip_operacao2']
                                 , "T106_conta"             => $_POST['T106_conta2']
                                 , "T106_status"            => "0"
                                 , "T106_cpf"               => $_POST['T106_cpf2']
                                 , "T106_valor_vista"       => $_POST['T106_valor_vista2']
                                 , "T106_valor_tot"         => $_POST['T106_valor_vista2']
                                 , "T106_n_cupom"           => $_POST['T106_n_cupom2']
                                 , "T106_pdv"               => $_POST['T106_pdv2']
                                 , "T106_func_libe"         => $_POST['T106_func_libe2']
                                 , "T004_login    "         => $_SESSION['user']
                                 , "T106_dat_lanc"          => $dataIn
                                 , "T006_codigo"            => $lojaIn
                                 , "T106_motivo"            => $_POST['T106_motivo']    
                                 , "T106_justificativa"     => $_POST['T106_justificativa']
                                 , "T106_instrucoes"        => $_POST['T106_instrucoes']
                                 , "T106_st_ajuste"         => $_POST["T106_st_ajuste2"]
                                             
                                    );  
                                        
                                        
                                        
                                    }
    
    $insere     = $obj->inserir($tabela_106, $camposT106);
    
    
    $numeroND = $obj->retornaND();
    
    foreach($numeroND as $campos=>$valores){
        
        $codigoND = $valores['codigo'];
        
    }
    
    //Recupera número da etapa para o grupo workflow
    
    
    
    $Etapa = $obj->retornaEtapaGrupo($_POST['T059_codigo']);
    
    foreach($Etapa as $campos=>$valores){
        
        $CamposEtapa = array( "T060_codigo"         => $valores['EtapaCodigo']
                            , "T106_codigo"         => $codigoND
                            , "T006_codigo"         => $lojaIn
                            , "T106_T060_ordem"     => 1
                            , "T106_T060_status"    => 0
                            , "T004_login"          => $_SESSION['user']
                            );
        
        $insereEtapa = $obj->inserir($tabela106060, $CamposEtapa);
        
        $insereFluxo = $obj->InserirFluxo($codigoND, $lojaIn, $valores['ProxEtapaCodigo'], 2, $_SESSION['user']);
        
    }
    
    

    
    
    
    
    
}

?>
