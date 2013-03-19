<?php
    
    $connORA    =   "ora";               

    $objORA     =   new models_T0088($connORA);

    $CRF        =   $_REQUEST['CRF'];
           
    // Busca Descrição das CRFs para cadastro
    $retornaDescricao  =   $objORA->retornaDescReduzida($CRF);
    
    
    while ($row_ora = oci_fetch_assoc($retornaDescricao))
    {
        //$descricao  =   $row_ora[1];
        echo trim($row_ora['DESCRICAO']);
    }    
   
    
?>
