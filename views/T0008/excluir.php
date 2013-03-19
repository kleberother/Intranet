<?php
//Chama classes
$pagina        =    $_GET["pagina"];
$cod           =    $_GET["cod"];
$tabela        =    $_GET["tabela"];
$delim         =    $_GET["campo"]." = ".$_GET["valor"];

//Classe para Usuarios
$objExcluir     =   new models_T0008();
$Excluir        =   $objExcluir->excluiT056($tabela, $delim);

if (is_null($cod))
{
    header('location:?router='.$pagina);
}
else
{
    header('location:?router='.$pagina."&cod=".$cod);
}


?>