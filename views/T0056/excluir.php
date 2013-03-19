<?php
//Inputs
$pagina        =    $_GET["pagina"];
$cod           =    $_GET["valor"];
$tabela        =    $_GET["tabela"];
$tipo          =    $_GET["tipo"];
$campos        =    $_GET["campo"];

//Separa os campos dentro de um array de Codigo do Produto e código do Arquivo
$campos             =   explode(",",$campos);
$CampoArquivoCodigo =   $campos[0];
$CampoProdutoCodigo =   $campos[1];

//Separa os valores dentro de um array de Codigo do Produto e Código do Arquivo
$cod                =   explode(",",$cod);
$ArquivoCodigo      =   $cod[0];
$ProdutoCodigo      =   $cod[1];

//Delimitador para Excluir Produto associado ao arquivo
$delim         =    $CampoProdutoCodigo." = ".$ProdutoCodigo;

//Classe para Usuarios
$objExcluir     =   new models_T0056();
$Excluir        =   $objExcluir->excluir($tabela, $delim);

//Delimitador para Excluir Arquivo
$delim          =   $CampoArquivoCodigo." = ".$ArquivoCodigo;

//excluir Arquivo
$tabela         =   "T055_arquivos";
$Excluir        =   $objExcluir->excluir($tabela, $delim);

$fn = CAMINHO_ARQUIVOS.'CAT0014/'.$objExcluir->preencheZero("E", 8, $ArquivoCodigo);
// Exclui arquivo
$ret = unlink($fn);


if (is_null($cod))
{
    header('location:?router='.$pagina);
}
else
{
    header('location:?router='.$pagina."&ProdutoCodigo=".$ProdutoCodigo);
}
?>