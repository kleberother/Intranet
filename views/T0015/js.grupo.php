<?php 
//Captura código jQuery
$cod            =   $_POST['processo'];
//Abre instancia Classe
$objWorkflow    =   new models_T0015();
$Workflow       =   $objWorkflow->selecionaGrpWork($cod);

if ($_POST['tipo']==1)
{
    unset($_POST['tipo']);
    
    $tabela =   "T060_workflow";

    if($_POST['T060_proxima_etapa']=="")
        $_POST['T060_proxima_etapa'] = "null";

    $insere = $objWorkflow->inserir($tabela, $_POST);

    echo $objWorkflow->lastInsertId();

}
else
{

    //Quando value do Combo/Select for ZERO
    if($cod==0)
    {
        echo '<option value="0">Selecione um Processo...</option>';
    }
    else
    {
        $i=0;
        foreach($Workflow   as  $campos=>$valores)
        {
            echo '<option value="'.$valores['COD'].'">'.$valores['NOM'].'</option>';
            $i++;
        }
    }

    if($i==0)
    {
    echo '<option value="0">Selecione um Processo...</option>';
    }

}
?>
