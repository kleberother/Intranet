<?php


$Sep = ',' ; // separador dos campos do array do GET
//Instancia classe
$objExcluir     =   new models_T0034();
//Chama classes
echo $pagina        =    $_GET["pagina"];

// $paginaPOST    = str_replace($search, $replace, $subject)

$PainelCod     =    $_GET["Painel"];
$tabela        =    $_GET["tabela"];
$tipo          =    $_GET["tipo"];

if($tipo==1)
{
    // recebe o array dos campos para exclusao separados por "," (virgula)
    $CamposDelim    = split($Sep,$_GET["campo"]);
    $ValoresDelim   = split($Sep,$_GET["valor"]);

    $ItemCodigo     =   $ValoresDelim[0];   //código do Item
    $PainelCodigo   =   $ValoresDelim[1];   //código do Painel
    $AreaCodigo     =   $ValoresDelim[2];   //código da área

    //Delimitador para Delete
    $Where ="     T075_codigo=".$ItemCodigo.
            " AND T078_codigo=".$PainelCodigo.
            " AND T080_codigo=".$AreaCodigo
            ;

    //Classe para Usuarios    
    $Excluir        =   $objExcluir->excluir($tabela, $Where);
    header('location:?router='.$pagina."&Painel=$PainelCodigo");    
}
else
{
    $Where ="     T078_codigo=".$PainelCodigo = $_GET["valor"];

    //Classe para Usuarios    
    $Excluir        =   $objExcluir->excluir($tabela, $Where);
    header('location:?router='.$pagina);    
}


?>