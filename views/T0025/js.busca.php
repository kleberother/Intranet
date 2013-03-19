<?php

$tipo               =   $_GET['tipo'];

//Instancia Classe
$conn               =   "ora";
$objBuscaAP         =   new models_T0025($conn);
$obj                =   new models_T0025(); 

//EXECUTADO PELO busca.js do PROGRAMA T0025

/* =========== T I P O S =========== */
//TIPO 1 = BUSCA DADOS RMS POR CNPJ
//TIPO 2 = BUSCA DADOS RMS POR CÓDIGO RMS
//TIPO 3 = RETORNA LISTA DE GFW QUE PODERÃO SER ASSOCIADOS


if  ($tipo    ==  1)
{

    $cnpj               =   $_GET['cnpj'];
    $cod                =   $_GET['cod'];

    //Trata CNPJ
    $cnpj = str_replace(".", "", $cnpj);
    $cnpj = str_replace("/", "", $cnpj);
    $cnpj = str_replace("-", "", $cnpj);
    $cnpj = str_pad($cnpj, 14, "0", STR_PAD_LEFT);

    //Zera o código
    $cod    =   0;

    //Seleciona dados do Fornecedor do RMS
    $FornRMS            =   $objBuscaAP->selecionaFornRMS($cnpj,$cod);

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
    $FornRMS            =   $objBuscaAP->selecionaFornRMS($cnpj,$cod);

    //Retorna JSON para jQuery buscaCodRMS/buscaCnpjRMS em ARRAY
    while ($row_ora = oci_fetch_assoc($FornRMS))
    {
        echo json_encode($row_ora);
    }
}
else if ($tipo   ==  3)
{

    $fornecedor         =   $_GET['fornecedor'];
    $loja               =   $_GET['loja'];
    
    
    // Retorna a lista dos grupos associados de acordo com o fornecedor e loja
    $ComboGWF = $obj->listarGrpAssociados($fornecedor, $loja);
    
    foreach($ComboGWF as $campos=>$valores)
    {
        $html  .= '<option value="'.$valores['Codigo'].'">'.$obj->preencheZero("E", 3, $valores['Codigo'])." - ".$valores['Nome'].'</option>';
    }
    
    //Retorno para o jQuery
    echo json_encode($html);   
}

?>
