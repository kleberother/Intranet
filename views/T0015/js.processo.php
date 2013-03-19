<?php 
//Abre instancia Classe
$objWorkflow    =   new models_T0015();
$Processo       =   $objWorkflow->selecionaProcesso();



$i=0;
foreach($Processo   as  $campos=>$valores)
{
    echo '<option value="'.$valores['COD'].'">'.$valores['NOM'].'</option>';
    $i++;
}

if ($i==0)
{
    echo '<option value="0">Cadastre um processo</option>';
}


?>
