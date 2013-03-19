<?php
//Funções remotas para jQuery e JavaScript


//De acordo com o GetFunction apontará 
$Function   =   $_GET['getFunction'];
$Args       =   $_GET['Args']       ;


//Função para somar
Function Soma($Args)
{
    echo array_sum($Args);
}

//Chama Função 
$Function($Args);

?>
