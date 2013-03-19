<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 13/03/2013 Roberta Schimidt    
 * Descrição: Incluir Executores RM
 * Entradas:   
 * Origens:   
           
**************************************************************************
*/
$conn   = "";
$obj    = new models_T0117();


if ($_REQUEST['cod'] == 2) {
    
 $codRM      =  $_REQUEST["codRM"];  
 $login      =  $_REQUEST["login"];  
 
 $tabela     =   "T004_T113";
        
        $user       =   $login;
        $dadosUser  =   $obj->retornaDadosUsuario($user);
        
        foreach($dadosUser as $cp   =>  $vl)
        {
            $nomeUsuario    =   $vl['NomeUsuario'];
            $emailUsuario   =   $vl['EmailUsuario'];
        }
                
        $campos =   array(
                            "T113_codigo"           =>  $codRM
                         ,  "T004_login"            =>  $login
                         ,  "T004_T113_nome"        =>  $nomeUsuario
                         ,  "T004_T113_email"       =>  $emailUsuario
                         ,  "T004_T113_telefone"    =>  ""
                         ,  "T004_T113_notificado"  =>  ""
                         ,  "T004_T113_tipo"        =>  2               //Tipo 1 = Responsaveis RM
                         );

$obj->inserir($tabela, $campos); 

        } elseif($_REQUEST["cod"]   ==  1){
            
        $codRM      =  $_REQUEST["codRM"];  
        $login      =  $_REQUEST["login"];
            
        $tabela     =   "T004_T113";
        
        $user       =   $login;
        $dadosUser  =   $obj->retornaDadosUsuario($user);
        
        foreach($dadosUser as $cp   =>  $vl)
        {
            $nomeUsuario    =   $vl['NomeUsuario'];
            $emailUsuario   =   $vl['EmailUsuario'];
        }
                
        $campos =   array(
                            "T113_codigo"           =>  $codRM
                         ,  "T004_login"            =>  $login
                         ,  "T004_T113_nome"        =>  $nomeUsuario
                         ,  "T004_T113_email"       =>  $emailUsuario
                         ,  "T004_T113_telefone"    =>  ""
                         ,  "T004_T113_tipo"        =>  1               //Tipo 1 = Responsaveis RM
                         );
        
  
       $obj->inserir($tabela, $campos);
       
       } elseif($_REQUEST["cod"]    ==  3){
           
            $tabela     =   "T004_T113";
            $codRM      =  $_REQUEST["codRM"];  
            $nome       =  $_REQUEST["nome"];
            $tel        =  $_REQUEST["tel"];
            $notif      =  $_REQUEST["notif"];
            $email      =  $_REQUEST["email"]; 
            
        
        $campos =   array(
                            "T113_codigo"           =>  $codRM
                         ,  "T004_T113_nome"        =>  $nome
                         ,  "T004_T113_email"       =>  $email
                         ,  "T004_T113_telefone"    =>  $tel
                         ,  "T004_T113_notificado"  =>  $notif
                         ,  "T004_T113_tipo"        =>  3               //Tipo 3 = Responsaveis RM Externo
                         );
        
       
          $obj->inserir($tabela, $campos);
           
       }
?>
