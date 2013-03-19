<?php

$obj = new models_home();

$user               =   $_SESSION['user']                           ;   

$ApPendente         =   $obj->retornaQtdApPendente($user)           ;
$ApAnteriores       =   $obj->retornaQtdApAnteriores($user)         ;
$DespesaPendente    =   $obj->retornaQtdDespesaPendente($user)      ;
$DespesaAnteriores  =   $obj->retornaQtdDespesasAnteriores($user)   ;
$ApForaPrazo        =   $obj->retornaQtdApsForaPrazo($user)         ;
$ApDentroPrazo      =   $obj->retornaQtdApsDentroPrazo($user)       ;

if(!empty($user))
{
    foreach($ApPendente as $campos => $valores)
    {
        $QtdeApPendente         =   $valores['Qtde'];
    }
      
    foreach($ApAnteriores as $campos => $valores)
    {
        $QtdeApAnteriores       =   $valores['Qtde']; 
    }
    
    foreach($DespesaPendente as $campos => $valores)
    {
        $QtdeDespesaPendente    =   $valores['Qtde'];
    }
    
    foreach($DespesaAnteriores as $campos => $valores)
    {
        $QtdeDespesaAnteriores  =   $valores['Qtde'];
    }
    
    foreach($ApForaPrazo as $campos => $valores)
    {
        $QtdeApForaPrazo        =   $valores['Qtde'];
    }
    
    foreach($ApDentroPrazo as $campos => $valores)
    {
        $QtdeApDentroPrazo      =   $valores['Qtde'];
    }
    
    $Dados = array(  "QtdeApPendente"         =>  $QtdeApPendente
                    ,"QtdeApAnteriores"       =>  $QtdeApAnteriores
                    ,"QtdeDespesaPendente"    =>  $QtdeDespesaPendente
                    ,"QtdeDespesaAnteriores"  =>  $QtdeDespesaAnteriores
                    ,"QtdeApForaPrazo"        =>  $QtdeApForaPrazo
                    ,"QtdeApDentroPrazo"      =>  $QtdeApDentroPrazo
                  );
    
    echo json_encode($Dados);
}
else
    echo "0";   //resposta para js, não mostrar a caixa de dialogo







?>