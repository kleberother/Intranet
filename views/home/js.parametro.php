<?php

$obj                =   new models_home()                                       ;

$codigoParametro    =   $_REQUEST['codigoParametro']                            ;
$user               =   $_SESSION['user']                                       ;   
$Parametro          =   $obj->retornaValorParametroUsuario($codigoParametro, $user)    ;

foreach($Parametro as $campos=>$valores)
{
    $valorParametroUser =   $valores['ValorParametro'];   
}

if (empty($valorParametroUser))
{
    $Parametro  =   $obj->retornaValorParametro($codigoParametro);
    
    foreach($Parametro  as  $campos=>$valores)
    {
        $valorParametro =   $valores['ValorParametro'];
    }
}else
    $valorParametro =   $valorParametroUser;

echo $valorParametro; //retorno

?>