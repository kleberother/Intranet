<?php
$user               =   $_SESSION['user'];
$tipo               =   $_GET['tipo'];
// Tipo de Filtro do combo principal
$filtro             =   $_GET['filtro'];
$loja               =   $_GET['loja'];
//Instancia Classe
$conn               =   "ora";
$objBuscaAP         =   new models_T0016($conn);


//EXECUTADO PELO busca.js do PROGRAMA T0016

/* =================================== T I P O S ============================= */
//TIPO 1 = BUSCA DADOS RMS POR CNPJ
//TIPO 2 = BUSCA DADOS RMS POR CÓDIGO RMS
//TIPO 3 = BUSCA GRUPO ASSOCIADO AO FORNECEDOR
//TIPO 4 = BUSCA GRUPO DO USUARIO E DEPENDENTES
//TIPO 5 = INCLUI FORNECEDOR POR CNPJ
//TIPO 6 = INCLUI FORNECEDOR POR CPF
//TIPO 7 = BUSCA SE HÁ NOTAS FISCAIS COM O MESMO NÚMERO E FORNECEDOR
//TIPO 8 =
//TIPO 9 =
//TIPO 10= PARA COMBO DE FILTRO

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
    $cnpj               =   $_GET['cnpj'];

    //Trata CNPJ
    $cnpj = str_replace(".", "", $cnpj);
    $cnpj = str_replace("/", "", $cnpj);
    $cnpj = str_replace("-", "", $cnpj);
    //Completa com zero a esquerda
    $cnpj = str_pad($cnpj, 14, "0", STR_PAD_LEFT);

    $conn               =   "";
    $objBusca           =   new models_T0016($conn);
    $Forn               =   $objBusca->selecionaForn($cnpj);

    foreach($Forn as $campo=>$valores)
    {
        $cod        =   $valores['COD'];
    }

    $GrpWfk         =   $objBusca->buscaGrupo($cod, $loja);

    $i = 0;
    foreach($GrpWfk as  $campos=>$valores)
    {
        echo '<option value="'.$valores['COD'].'">'.$valores['COD'].' - '.$valores['NOM'].'</option>';
        $i++;
    }

    if($i == 0 )
    {
        echo "0";
    }
}
else if ($tipo == 4)
{
    $conn               =   "";
    $ap                 =   $_GET['ap'];
    $obj                =   new models_T0016($conn);
    $Forn               =   $obj->selecionaAPDF($ap);

    foreach($Forn as  $campos=>$valores)
    {
        echo '<option value="'.$valores['P0016_T059_COD'].'">'.$valores['P0016_T059_COD'].' - '.$valores['P0016_T059_NOM'].'</option>';
    }

}

if ($tipo==5)
{
    //INSERI EM T026_fornecedor
    $tabela     =   "T026_fornecedor";
    $cnpj       =   $_GET['cnpj'];
    $codCNPJ    =   $_GET['cod_cnpj'];
    $ie         =   $_GET['ie'];
    $im         =   $_GET['im'];
    $raz        =   $_GET['raz'];
    $conn       =   "";
    $objGrpDP     =   new models_T0016($conn);

    $cnpj   =   $objGrpDP->retiraMascara($cnpj);
    $cnpj   =   $objGrpDP->preencheZero("E", 14, $cnpj);

    $Forn       =   $objGrpDP->selecionaForn($cnpj);

    $i          =   0;
    foreach($Forn as $campos=>$valores)
    {
        echo $codForn    =   $valores['COD'];
        $i++;
    }

    //Trata código RMS
    $codRMS_CNPJ        =   substr($codCNPJ, 0, -1);
    $digRMS_CNPJ        =   substr($codCNPJ, -1);

    //Se não existe fornecedor em T026_fornecedor INSERI
    if($i==0)
    {
        //Array para inserir T026_fornecedor
        $arrFornCNPJ    =   array( 'T026_rms_cgc_cpf'        =>$cnpj
                                 , 'T026_rms_codigo'         =>$codRMS_CNPJ
                                 , 'T026_rms_insc_est_ident' =>$ie
                                 , 'T026_rms_razao_social'   =>$raz
                                 , 'T026_rms_insc_mun'       =>$im
                                 , 'T026_rms_digito'         =>$digRMS_CNPJ);

        $objGrpDP->inserir($tabela, $arrFornCNPJ);
        echo $codForn    =   $objGrpDP->lastInsertId();
    }

}


if ($tipo == 6)
{
    $tabela     =   "T026_fornecedor";
    $cpf        =   $_GET['cpf'];
    $codCPF     =   $_GET['cod_cpf'];
    $rg         =   $_GET['rg'];
    $raz        =   $_GET['raz'];
    $conn       =   "";
    $objGrpDP     =   new models_T0016($conn);

    $cpf    =   $objGrpDP->retiraMascara($cpf);
    $cpf    =   $objGrpDP->preencheZero("E", 14, $cpf);

    $Forn       =   $objGrpDP->selecionaForn($cpf);

    $i          =   0;
    foreach($Forn as $campos=>$valores)
    {
        echo $codForn    =   $valores['COD'];
        $i++;
    }

    $codRMS_CPF         =   substr($codCPF, 0, -1);
    $digRMS_CPF         =   substr($codCPF, -1);

    if($i==0)
    {
        $arrFornCPF     =   array( 'T026_rms_cgc_cpf'        =>$cpf
                                 , 'T026_rms_codigo'         =>$codRMS_CPF
                                 , 'T026_rms_insc_est_ident' =>$rg
                                 , 'T026_rms_razao_social'   =>$raz
                                 , 'T026_rms_digito'         =>$digRMS_CPF);

        $objGrpDP->inserir($tabela, $arrFornCPF);
        echo $codForn    =   $objGrpDP->lastInsertId();
    }
}
if ($tipo == 7)
{
     $Ap    = $objAp->retornaApsPendentes($user);
     json_encode($Ap);
     $msgFiltro = $msgFiltro . "Aguardando minha Aprovação";
}

if ($tipo ==8)
{
    $Ap    = $objAp->retornaApsAprovadas($user);
    json_encode($Ap);
    $msgFiltro  =   $msgFiltro . "APs dos meus grupos";
}

if ($tipo ==9)
{
    $cnpj               =   $_GET['cnpj'];
    $nf_num             =   $_GET['nf_num'];
    //$serie              =   $_GET['serie'];

    //Trata CNPJ
    $cnpj = str_replace(".", "", $cnpj);
    $cnpj = str_replace("/", "", $cnpj);
    $cnpj = str_replace("-", "", $cnpj);
    //Completa com zero a esquerda
    //$cnpj = str_pad($cnpj, 14, "0", STR_PAD_LEFT);
    $conn               =   "";
    $objBusca           =   new models_T0016($conn);

    $APsNF              =   $objBusca->BuscaAPPorNF($cnpj,$nf_num);

    // inicia contador com 0

    echo json_encode($APsNF);
    
}

if ($tipo == 10)
{

    //Instancia classe
    $conn   =   "";
    $objAp  =   new models_T0016($conn);

    function CriaTabelaHTML($dados, $filtro)
    {

        $AD = "\"";
        $conn   =   "";
        $objAp  =   new models_T0016($conn);
        $i      =   0;

        foreach($dados as $campos=>$valores)
        {
            $cgc = $objAp->FormataCGCxCPF($valores['FornCNPJ']);
            $ValorBruto     = money_format('%n', $valores['ValorBruto']);
            $html[$i]  = "<tr class='dados'>";
            $html[$i] .= "<td>".$valores['APCodigo']."</td>";
            $html[$i] .= "<td>".$valores['NFNumero']."<br/>".$valores['NFSerie']."</td>";
            $html[$i] .= "<td>".$valores['FornRazaoSocial']."<br/>".$cgc."</td>";
            $html[$i] .= "<td>".$valores['Login']."</td>";
            $html[$i] .= "<td>";
            $Etapa  = $objAp->retornaUltimaAprovacao($valores['APCodigo']);
            foreach($Etapa  as  $camposEtp=>$valoresEtp)
            {
                $html[$i] .=$valoresEtp['GrupoCodigo'] = $objAp->preencheZero("E", 3, $valoresEtp['GrupoCodigo']) . "-" . $valoresEtp['GrupoNome'] .' ('. $valoresEtp['Login'] .')'. "</BR></BR>" . $valoresEtp['DtAprovacao']."</BR>". $valoresEtp['TimeAprovacao'];
            } 
            $html[$i] .= "</td>";
            $html[$i] .= "<td>".$valores['DtVencimento']."</td>";
            $html[$i] .= "<td>".$ValorBruto."</td>";
            $html[$i] .= "<td><table class='list-iten-arquivos'>";
                            $Arq = $objAp->selecionaArquivos($valores['APCodigo']);
                            foreach($Arq  as  $campos=>$valores2)
                            {
                                 if( $cont%2 == 0)
                                        $cor = "line_color";
                                 else
                                        $cor = "";
                                 $cont++;

                                 $lnkArq = $objAp->preencheZero("E", 4, $valores2['CAT'])."/".$arquivo=$objAp->preencheZero("E", 4, $valores2['ARQ']).".".$valores2['EXT'];
                                 $lnkBotao = $objAp->preencheZero("E", 4, $valores2['CAT'])."/".$arquivo=$objAp->preencheZero("E", 4, $valores2['ARQ']);

                                 $html[$i] .= "<tr class='".$cor."'>";
                                 $html[$i] .= "<td width='95%' ><a target='_blank' href=".$AD.CAMINHO_ARQUIVOS."CAT".$lnkArq.$AD.">".$valores2['NOM']."</a></td>";
                                 $html[$i] .= "<td width='5%'  ><a href=".$AD."javascript:excluir('T0016','T0016/home&cod=".$valores['APCodigo']."&path=".$lnkBotao."','T008_T055','T055_codigo','".$valores2['ARQ']."')".$AD." title='Excluir' class='excluir'></a></td>";
                                 $html[$i] .= "</a>";
                                 $html[$i] .= "</td>";
                                 $html[$i] .= "</tr>";
                            }
            $html[$i] .= "<!-- Caixa Dialogo Excluir -->";
            $html[$i] .= "<div id='dialog-confirm' title='Mensagem!' style='display:none'>";
            $html[$i] .= "<p><span class='ui-icon ui-icon-alert' style='float:left; margin:0 7px 20px 0;'></span>Tem certeza que deseja excluir este item?</p>";
            $html[$i] .= "</div>";
            $html[$i] .= "</table>";
            $html[$i] .= "</td>";
            $html[$i] .= "<td class='acoes'><span class='lista_acoes'><ul>";
            $html[$i] .= "<li class='ui-state-default ui-corner-all' title='Detalhes'><a href='?router=T0016/detalhe&cod=".$valores['APCodigo']."&orig=home'                                      class='ui-icon ui-icon-search'></a></li>";
            // $html[$i] .= "<li class='ui-state-default ui-corner-all' title='Últimas'><a href='?router=T0016/u&cod=".$valores['APCodigo']."&orig=home'                                      class='ui-icon ui-icon-search'></a></li>";
            if(($filtro == 1) || ($filtro == 2) || ($filtro == 3))
            {
                $html[$i] .= "<li class='ui-state-default ui-corner-all' title='Alterar' ><a href=".$AD."?router=T0016/altera&cod=".$valores['APCodigo']."&codfor=".$valores['FornCodigo'].$AD." class='ui-icon ui-icon-pencil'></a></li>";
                $html[$i] .= "<li class='ui-state-default ui-corner-all' title='Anexar'  ><a href=".$AD."javascript:upload(".$valores['APCodigo'].")".$AD."                             class='ui-icon ui-icon-arrowreturnthick-1-n' ></a></li>";
            }
            if(($filtro == 1) || ($filtro == 2) || ($filtro==4))
            {
                $html[$i] .= "<li class='ui-state-default ui-corner-all' title='Imprimir'  ><a href=".$AD."?router=T0016/pdf&cod=".$valores['APCodigo'].$AD."                           class='ui-icon ui-icon-print'                target='_blank' ></a></li>";
            }
            if($filtro ==   1)
            {
                $html[$i] .= "<li class='ui-state-default ui-corner-all' title='Aprovar'   ><a href=".$AD."javascript:aprovar('T0016','T0016/home','T008_T060','1','T008_codigo',".$valores['APCodigo'].",".$valores['CodigoEtapa'].")".$AD."   class='ui-icon ui-icon-check'></a></li>";
                $html[$i] .= "<li class='ui-state-default ui-corner-all' title='Cancelar'  ><a href=".$AD."javascript:cancelar('T0016','T0016/home','T008_approval','1','T008_codigo',".$valores['APCodigo'].",".$valores['CodigoEtapa'].")".$AD."   class='ui-icon ui-icon-cancel'></a></li>";
            }
            $html[$i] .= "</ul>";
            $html[$i] .= "</span>";
            $html[$i] .= "</td>";
            $html[$i] .= "</tr>";

            $i++;
        }

        //Retorno para o jQuery
        echo json_encode($html);

    }

    switch ($filtro)
    {
        case 1:
             $Ap    = $objAp->retornaApsPendentesAprovacao($user);
             CriaTabelaHTML($Ap, $filtro);
             break;
        case 2:
             $Ap    = $objAp->retornaApsDigitadas($user);
             CriaTabelaHTML($Ap, $filtro);
             break;
        case 3:
             $Ap    = $objAp->retornaApsAnteriores($user);
             CriaTabelaHTML($Ap, $filtro);
             break;
        case 4:
             $Ap    = $objAp->retornaApsPosteriores($user);
             CriaTabelaHTML($Ap, $filtro);
             break;
        case 5:
             $Ap    = $objAp->retornaApsFinalizadas($user);
             CriaTabelaHTML($Ap, $filtro);
             break;
        case 6:
             $Ap    = $objAp->retornaApsCanceladas($user);
             CriaTabelaHTML($Ap, $filtro);
             break;

    }

}
?>
