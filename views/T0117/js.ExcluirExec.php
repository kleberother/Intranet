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
        $login      =  $_POST["login"];  
 
        $tabela     =   "T004_T113";
        
        $delim   =   "T113_codigo       =    $codRM ";
        $delim  .=   "AND T004_login        =   '$login'"; 
        $delim  .=   "AND T004_T113_tipo    =   2";        


$obj->excluir($tabela, $delim); 

        } elseif($_REQUEST["cod"]   ==  1){
            
        $codRM      =  $_REQUEST["codRM"];  
        $login      =  $_REQUEST["login"];
            
        $tabela     =   "T004_T113";
        
        $delim   =   "T113_codigo       =    $codRM ";
        $delim  .=   "AND T004_login        =   '$login' "; 
        $delim  .=   "AND T004_T113_tipo    =   1" ;
    
       $obj->excluir($tabela, $delim);
       
       } elseif($_REQUEST["cod"]    ==  3){
           
            $tabela     =   "T004_T113";
            $codRM      =  $_REQUEST["codRM"];  
            $nome       =  $_REQUEST["nome"];
            $tel        =  $_REQUEST["tel"];
            $notif      =  $_REQUEST["notif"];
            $email      =  $_REQUEST["email"]; 
            
        
       
        $delim   =  "T004_T113_nome =   '$nome'";
        $delim  .=  "AND T004_T113_telefone = '$tel'"; 
        $delim  .=  "AND T004_T113_email = '$email'";
        $delim  .=  "AND T004_T113_notificado   =   '$notif'"; 
        $delim  .=  "AND T113_codigo  =   $codRM";
       
          $obj->excluir($tabela, $delim);
           
       } elseif ($_REQUEST["cod"]   ==  4) {
       
        $codRM      =  $_REQUEST["codRM"];  
        $login      =  $_REQUEST["login"];
            
        $tabela     =   "T004_T113";
        
        $delim   =   "T113_codigo       =    $codRM ";
        $delim  .=   "AND T004_login        =   '$login' "; 
        $delim  .=   "AND T004_T113_tipo    =   4" ;
        
        $obj->excluir($tabela, $delim);
           
           
}
?>
