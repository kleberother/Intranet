<?php 
    
    $obj        =   new models_T0084();  

    $CRF        =   $_REQUEST['CRF'];
    
    
   
    // Busca Locais de Atendimento referente a entidade escolhida
    $retornaDesc      =   $obj->retornaCRF($CRF);
    
    
    foreach($retornaDesc as $campos=>$valores)
    {
        echo json_encode($valores);
    }
    
    if(empty($valores))
    {
        echo "1";
    }
    //Retorno para o jQuery
    //echo json_encode($html);
    
    
?>
