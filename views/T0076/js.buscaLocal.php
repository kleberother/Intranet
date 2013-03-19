<?php
    
    $obj        =   new models_T0076();  

    $entidade   =   $_REQUEST['entidade'];
    
   
    // Busca Locais de Atendimento referente a entidade escolhida
    $local      =   $obj->retornaLocal($entidade);
    
    $html = "<option value=''>Selecione...</option>";
    
    foreach($local as $campos=>$valores)
    {
        $html  .= "<option value='".$valores['Codigo']."'>".$obj->preencheZero("E", 4, $valores['Codigo'])." - ".trim($valores['Nome'])."</option>";
    }

    //Retorno para o jQuery
    echo json_encode($html);
    
    
?>
