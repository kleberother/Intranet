<?php
//Chama classes
$pagina        =    $_GET["pagina"];
$cod           =    $_GET["cod"];
$codpro        =    $_GET["codpro"];
$tabela        =    $_GET["tabela"];
if(is_numeric($_GET["valor"]))
{
    $delim         =    $_GET["campo"]." = ".$_GET["valor"];
}
else
{
    $delim         =    $_GET["campo"]." = "."'".$_GET["valor"]."' AND T059_codigo = $cod AND T061_codigo = $codpro";
}

//Classe para Usuarios
$objExcluir     =   new models_T0014();
$Excluir        =   $objExcluir->excluiGrpWork($tabela, $delim);

if (is_null($cod))
{
    header('location:?router='.$pagina);
}
else
{
    header('location:?router='.$pagina."&cod=".$cod."&codpro=".$codpro);
}


?>