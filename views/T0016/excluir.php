<?php
//Chama classes
$pagina        =    $_GET["pagina"];
$cod           =    $_GET["cod"];
$tabela        =    $_GET["tabela"];
$path          =    $_GET["path"];

if(is_numeric($_GET["valor"]))
{
    $delim         =    $_GET["campo"]." = ".$_GET["valor"]." AND T008_codigo = $cod";
    $delim2        =    $_GET["campo"]." = ".$_GET["valor"];
}
else
{
    $delim         =    $_GET["campo"]." = "."'".$_GET["valor"]."' AND T008_codigo = $cod";
    $delim2        =    $_GET["campo"]." = "."'".$_GET["valor"]."'";
}

//EXCLUI DA TABELA T008_T055
$objExcluir     =   new models_T0016();
$Excluir        =   $objExcluir->excluir($tabela, $delim);

if ($Excluir)
{
 //EXCLUI DA TABELA T055_arquivos
 $tabela2 = "T055_arquivos";
 $Excluir2       =   $objExcluir->excluir($tabela2, $delim2);
 if ($Excluir2)
 {
    //header('location:?router='.$pagina.'&msg=10');
    $fn = CAMINHO_ARQUIVOS.'CAT'.$path;
    // Excluindo arquivo
    $ret = unlink($fn);
    if ($ret)
    {
     header('location:?router='.$pagina.'&msg=10');
    }
    else
    {
     header('location:?router='.$pagina.'&msg=2');
    }
 }
 else
  header('location:?router='.$pagina.'&msg=2');
}
else
 header('location:?router='.$pagina.'&msg=2');

//if (is_null($cod))
//{
//    header('location:?router='.$pagina);
//}
//else
//{
//    header('location:?router='.$pagina."&cod=".$cod);
//}


?>