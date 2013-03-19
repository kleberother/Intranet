<?php
$obj            =   new models_T0016()          ;
$evento         =   $_REQUEST['evento']         ;
$codigoAp       =   $_REQUEST['codigoAp']       ;
$dataVencimento =   $_REQUEST['dataVencimento'] ;

function VerificaVencimento($codigoAp)
{
    $obj        =   new models_T0016()                  ;
    $Vencimento =   $obj->retornaVencimento($codigoAp)  ;
    foreach($Vencimento as   $campos=>$valores)
    {
        $valorVencimento    =   $valores['Vencto'];
    }
    
    return $valorVencimento;
}

//Para Botão aprovar todos, quando for array, verifica data de vencimento das aps
if($evento == 1)
{    
    $v  =   false;
    if (is_array($codigoAp))
    {         
        array_shift($codigoAp);        
        foreach($codigoAp as $campos => $valores)
        {
            $valorVencimento = VerificaVencimento($valores);
            if(empty($valorVencimento))
            {  
                $v  =   true;
                echo 1;
                break;            
            }                       
        }
        
        if (!$v)
            echo 0;
        
    }else
    {
        $valorVencimento    =  VerificaVencimento($codigoAp); 
        if (empty($valorVencimento))
            echo 1;
        else
            echo 0;
    }
}
else if ($evento == 2)
{
    $tabela =   "T008_approval";
    
    $delim  =   "T008_codigo  = $codigoAp";
    
    $campos =   array("T008_nf_dt_vencto"    =>  $dataVencimento);
    
    $altera =   $obj->altera($tabela, $campos, $delim);
    
    if( $altera )
        echo 1;
    else
        echo 0;
}
?>