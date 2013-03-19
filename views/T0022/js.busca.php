<?php
//Instancia Classe

$obj    =   new models_T0022();


$Tipo   =   $_REQUEST['Tipo'];

//TIPO 2 = BUSCA OS POSTOS COM REFERENCIA AO POSTO DAVO ESCOLHIDO
if($Tipo    ==  2)
{
    $loja   =   $_REQUEST['loja'];

    //BUSCA COMBO-BOX PARA COMPLETAR O SELECT DE POSTOS CONCORRENTES DE ACORDO COM A LOJA ESCOLHIDA
    $ComboPostos = $obj->retornaPostoPorLoja($loja);

    $html = '<option value="">Selecione...</option>';
    foreach($ComboPostos as $campos=>$valores)
    {
        $html  .= '<option value="'.$valores['Codigo'].'">'."Influência: ".$valores['Influencia']." | "."Distância (Km): ".$valores['Distancia']." | ".$valores['NomePosto']." | ".$valores['Bandeira'].'</option>';
    }

    //Retorno para o jQuery
    echo json_encode($html);

}

//TIPO 3 = BUSCA OS DADOS DE PREÇO DO POSTO DAVO REFERENCIADO DA ULTIMA PESQUISA REALIZADA
if($Tipo    ==  3)
{
    $loja   =   $_REQUEST['loja'];

    //
    $ImportaPesq = $obj->retornaUltimaPesquisa($loja);
    
    foreach($ImportaPesq as $campos=>$valores)
    {
     echo json_encode($valores);
    }
    
    if(empty($valores))
    {
        echo "1";
    }
}


?>
