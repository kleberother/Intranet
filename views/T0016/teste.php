<?php

//Instancia Classe
$objP0016         =   new models_T0016();

//Captura Login para inserção
$user           =   $_SESSION['user'];
$data           =   date('d/m/Y H:i:s');
$tipo           =   $_GET['tipo'];
$ap             =   $_GET['ap'];
//Verifica se CNPJ não é nulo

if (!empty ($ap))
{
$ListaAP       =   $objP0016->TemporariaInclusaoFluxoAP($ap);
foreach($ListaAP as $campos=>$valores)
{
    echo "AP n°:".$valores['CodigoAP']."<br/>";


    $tabela = "T008_T060";
    $Etapa = $objP0016->retornaEtapaGrupo($valores['CodigoGP']);
    foreach($Etapa as $campos2=>$valores2)
    {
        $array = array ( "T060_codigo"=>$valores2['EtapaCodigo']
                       , "T008_codigo"=>$valores['CodigoAP']
                       , "T008_T060_ordem"=>1
                       , "T008_T060_status"=>0
                       , "T004_login"=>$valores['Login']);

        print_r($array);
        $insere2 = $objP0016->inserir($tabela, $array);
        $insere3 = $objP0016->TemporariaInserirFluxoAp($valores['CodigoAP'], $valores2['ProxEtapaCodigo'], 2, $valores['Login']);

    }
}
}


?>