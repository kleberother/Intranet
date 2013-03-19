<?php
//Instancia Classe
$conn   =   "";
$obj    =   new models_T0022();

//Tipo 1 = Primeira parte da pesquisa, Tipo 2 = Segunda parte da pesquisa
$Tipo   =   $_REQUEST['Tipo'];


if($Tipo    ==  1)
{
    $tabela             =   "T072_pesquisas_postos";
    $PostoId            =   $_REQUEST['PostoId'];
    $Usuario            =   $_REQUEST['Usuario'];
    $Data               =   $_REQUEST['Data'];
    
    $CustoGC            =   str_replace(".", ",",$_REQUEST['CustoGC']);
    $VendaGC            =   str_replace(".", ",",$_REQUEST['VendaGC']);
    $MargemGC           =   str_replace(".", ",",$_REQUEST['MargemGC']);

    $CustoGA            =   str_replace(".", ",",$_REQUEST['CustoGA']);
    $VendaGA            =   str_replace(".", ",",$_REQUEST['VendaGA']);
    $MargemGA           =   str_replace(".", ",",$_REQUEST['MargemGA']);

    $CustoEC            =   str_replace(".", ",",$_REQUEST['CustoEC']);
    $VendaEC            =   str_replace(".", ",",$_REQUEST['VendaEC']);
    $MargemEC           =   str_replace(".", ",",$_REQUEST['MargemEC']);


    $CustoEA            =   str_replace(".", ",",$_REQUEST['CustoEA']);
    $VendaEA            =   str_replace(".", ",",$_REQUEST['VendaEA']);
    $MargemEA           =   str_replace(".", ",",$_REQUEST['MargemEA']);

    $CustoDI            =   str_replace(".", ",",$_REQUEST['CustoDI']);
    $VendaDI            =   str_replace(".", ",",$_REQUEST['VendaDI']);
    $MargemDI           =   str_replace(".", ",",$_REQUEST['MargemDI']);

    $CustoGN            =   str_replace(".", ",",$_REQUEST['CustoGN']);
    $VendaGN            =   str_replace(".", ",",$_REQUEST['VendaGN']);
    $MargemGN           =   str_replace(".", ",",$_REQUEST['MargemGN']);

    $campos =   array(   "T072_data"       => "$Data"
                        ,"T072_GC_custo"   => "$CustoGC"
                        ,"T072_GC_preco"   => "$VendaGC"
                        ,"T072_GC_margem"  => "$MargemGC"
                        ,"T072_GA_custo"   => "$CustoGA"
                        ,"T072_GA_preco"   => "$VendaGA"
                        ,"T072_GA_margem"  => "$MargemGA"
                        ,"T072_EC_custo"   => "$CustoEC"
                        ,"T072_EC_preco"   => "$VendaEC"
                        ,"T072_EC_margem"  => "$MargemEC"
                        ,"T072_EA_custo"   => "$CustoEA"
                        ,"T072_EA_preco"   => "$VendaEA"
                        ,"T072_EA_margem"  => "$MargemEA"
                        ,"T072_DI_custo"   => "$CustoDI"
                        ,"T072_DI_preco"   => "$VendaDI"
                        ,"T072_DI_margem"  => "$MargemDI"
                        ,"T072_GN_custo"   => "$CustoGN"
                        ,"T072_GN_preco"   => "$VendaGN"
                        ,"T072_GN_margem"  => "$MargemGN"
                        ,"T006_codigo"     => "$PostoId"
                        ,"T004_login"      => "$Usuario"
                      );
    
    $Inseri     =   $obj->inserir($tabela, $campos);
    $id    =   $obj->lastInsertId($Inseri);
    echo trim($id);
}

if($Tipo    ==  2)
{
    $tabela           =   "T073_pesquisas_postos_concorrentes";
    $PostoId          =   $_REQUEST['PostoId'];
    $PesquisaId       =   $_REQUEST['PesquisaId'];

    $ValGC            =   str_replace(".", ",", $_REQUEST['ValGC']);
    $ValGA            =   str_replace(".", ",", $_REQUEST['ValGA']);
    $ValEC            =   str_replace(".", ",", $_REQUEST['ValEC']);
    $ValEA            =   str_replace(".", ",", $_REQUEST['ValEA']);
    $ValDI            =   str_replace(".", ",", $_REQUEST['ValDI']);
    $ValGN            =   str_replace(".", ",", $_REQUEST['ValGN']);

    $campos =   array(   "T073_GC_preco"   => "$ValGC"
                        ,"T073_GA_preco"   => "$ValGA"
                        ,"T073_EC_preco"   => "$ValEC"
                        ,"T073_EA_preco"   => "$ValEA"
                        ,"T073_DI_preco"   => "$ValDI"
                        ,"T073_GN_preco"   => "$ValGN"
                        ,"T070_codigo"     => "$PostoId"
                        ,"T072_codigo"     => "$PesquisaId"
                      );

    $Inseri     =   $obj->inserir($tabela, $campos);
    $id    =   $obj->lastInsertId($Inseri);
    echo trim($id);
}


?>
