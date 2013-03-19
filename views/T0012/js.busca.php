<?php

$tipo               =   $_GET['tipo'];

//Instancia Classe
$conn               =   "ora";
$objTitulo          =   new models_T0012($conn);

//EXECUTADO PELO busca.js do PROGRAMA T0012

/* =========== T I P O S =========== */
//TIPO 1 = BUSCA DADOS RMS POR CNPJ
//TIPO 2 = BUSCA DADOS RMS POR CÓDIGO RMS


if  ($tipo    ==  1)
{

    $cnpj               =   $_GET['cnpj'];
    $cod                =   $_GET['cod'];

    //Trata CNPJ
    $cnpj = $objTitulo->retiraMascara($cnpj);

    //Zera o código
    $cod    =   0;

    //Seleciona dados do Fornecedor do RMS
    $FornRMS            =   $objTitulo->selecionaFornRMS($cnpj,$cod);
    //Retorna JSON para jQuery buscaCodRMS/buscaCnpjRMS em ARRAY
    while ($row_ora = oci_fetch_assoc($FornRMS))
    {
        echo json_encode($row_ora);
    }

}
else if ($tipo   ==  2)
{
    $cnpj               =   $_GET['cnpj'];
    $cod                =   $_GET['cod'];

    //Zera CNPJ
    $cnpj               =   "";

    //Seleciona dados do Fornecedor do RMS
    $FornRMS            =   $objTitulo->selecionaFornRMS($cnpj,$cod);
    //Retorna JSON para jQuery buscaCodRMS/buscaCnpjRMS em ARRAY
    while ($row_ora = oci_fetch_assoc($FornRMS))
    {
        echo json_encode($row_ora);
    }

}
else if ($tipo   ==  3)
{
    $cod                =   $_GET['cod'];
    $titulo             =   $_GET['titulo'];
    $desd               =   $_GET['desd'];
    $serie              =   $_GET['serie'];

    //Seleciona dados do Fornecedor do RMS
    $Titulo            =   $objTitulo->selecionaTitulos($cod, $titulo, $desd, $serie);
    //Retorna JSON para jQuery buscaCodRMS/buscaCnpjRMS em ARRAY
    while ($row_ora = oci_fetch_assoc($Titulo))
    {
        echo json_encode($row_ora);
    }

}

?>
