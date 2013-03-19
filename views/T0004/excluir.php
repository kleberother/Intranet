<?php



//Chama classes
$pagina        =    $_GET["pagina"];
$cod           =    $_GET["cod"];
$nom           =    $_GET["nom"];
$tabela        =    $_GET["tabela"];
$tipo          =    $_GET["tipo"];


if ($tipo ==1)
{


    $delim         =    $_GET["campo"]." = ".$_GET["valor"];


    //Classe para Usuarios
    $objExcluir     =   new models_T0004();
    $Excluir        =   $objExcluir->excluiEstrutura($tabela, $delim);

    if (is_null($cod))
    {
        header('location:?router='.$pagina);
    }
    else
    {
        header('location:?router='.$pagina."&cod=".$cod."&nom=".$nom);
    }
}
else
{
    $delim         =    $_GET["campo"]." = ".$_GET["valor"]." AND ". $_GET["campo2"]. " = ". $_GET["valor2"];


    //Classe para Usuarios
    $objExcluir     =   new models_T0004();
    $Excluir        =   $objExcluir->excluiEstrutura($tabela, $delim);

    if (is_null($cod))
    {
        header('location:?router='.$pagina);
    }
    else
    {
        header('location:?router='.$pagina."&cod=".$cod."&nom=".$nom);
    }
}
?>