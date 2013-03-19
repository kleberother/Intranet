<?php

// Objeto de Conexão
$obj = new models_T0010();

$Busca    = $obj->buscaUsuarioSemEmail();

foreach($Busca as $campos=>$valores)
{
    $delim  =   "T004_login = '".strtolower($valores['Login'])."'";
    
    $email  =   strtolower($valores['Login']."@davo.com.br");
    
    $campos =   array("T004_email" => $email);
    
    $tabela =   "T004_usuario";
    
    $altera =   $obj->alterar($tabela, $campos, $delim);
            
}




?>

