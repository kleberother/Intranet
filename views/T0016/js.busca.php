<?php
$user               =   $_SESSION['user'];
$tipo               =   $_GET['tipo'];
// Tipo de Filtro do combo principal
$status             =   $_GET['status'];
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

if ($tipo == 5)
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

    function CriaTabelaHTML($dados, $status)
    {

        $AD = "\"";
        $conn   =   "";
        $objAp  =   new models_T0016($conn);
        $i      =   0;

        foreach($dados as $campos=>$valores)
        {
            if ($valores['NFNumero']=='null')
                $valores['NFNumero']    =   "";
                          
            if ($valores['ExpiradoDias']>=1)
                $CorFonte   =   ' style="color:red;"';
            else
                $CorFonte   =   "";
            
            $cgc = $objAp->FormataCGCxCPF($valores['FornCNPJ']);
            $ValorBruto     = money_format('%n', $valores['ValorBruto']);
            $html[$i]  = "<tr class='dados'>";
            // Status de Aprovacao
            if($status ==   1)
            {
                $html[$i] .= "<td $CorFonte><input type='checkbox' name='selecionaItem[]' id='selecionaItem' value='".$valores['APCodigo']."&".$valores['CodigoEtapa']."&".$valores['TpNota']."'></td>";
            }else
            {
                $html[$i] .= "<td $CorFonte><input type='checkbox' name='selecionaItem[]' id='selecionaItem' value='".$valores['APCodigo']."&".$valores['CodigoEtapa']."&".$valores['TpNota']."' disabled></td>";
            }
            $html[$i] .= "<td $CorFonte class='ap_codigo'>".$valores['APCodigo']."</td>";
            $html[$i] .= "<td $CorFonte>".$valores['NFNumero']."<br/>".$valores['NFSerie']."</td>";
            $html[$i] .= "<td $CorFonte>".$valores['FornRazaoSocial']."<br/>".$cgc."</td>";
            $html[$i] .= "<td $CorFonte>".$valores['Login']."</td>";
            
            //Inicio Tooltip            
            $buscaFluxo = $objAp->BuscaFluxo($valores['APCodigo']);
            
            $AD =   '"';
            $htmlTooltip = "<table>";
            $htmlTooltip .= "<tr>";
            $htmlTooltip .=     "<td><b>Grupos:</b></td>";
            $htmlTooltip .=     "<td>&nbsp;&nbsp;</td>";
            $htmlTooltip .=     "<td><b>Status Aprovações:</b></td>";
            $htmlTooltip .= "</tr>";
            foreach($buscaFluxo as $campos=>$vlsFluxo)
            {
                $BuscaGrupo = $objAp->BuscaGruposNomes($vlsFluxo["Codigo59"]);
                foreach ($BuscaGrupo as $cgrp=>$vlrgrp)
                { 
                    $htmlTooltip .= "<tr>";
                    $htmlTooltip .=     "<td>".$vlrgrp['Codigo'] = $objAp->preencheZero('E', 3, $vlrgrp['Codigo']). " - " .$vlrgrp['Nome']."</td>";
                    $htmlTooltip .=     "<td>&nbsp;&nbsp;</td>";
                    if ($vlsFluxo["Status"] == 1)
                        $htmlTooltip .=     "<td><b>em:</b> ".$vlsFluxo["DtAprovacao"]."<b>&nbsp;&nbsp;por:</b> ".strtolower($vlsFluxo["Login"])."</td>";
                    else
                        $htmlTooltip .=     "<td>Não Aprovado</td>";          

                    $htmlTooltip .= "</tr>";
                }
            }
                $htmlTooltip .="</table>";
                
            //Fim Tooltip
                
            
            $html[$i] .= "<td $CorFonte onmouseover ='show_tooltip_alert(".$AD."".$AD.",".$AD."$htmlTooltip".$AD.");tooltip.pnotify_display();' 
                              onmousemove ='tooltip.css({".$AD."top".$AD.": event.clientY+12, ".$AD."left".$AD.": event.clientX+12, ".$AD."width".$AD.": 400});' 
                              onmouseout  ='tooltip.pnotify_remove();'>";
            $Etapa  = $objAp->retornaUltimaAprovacao($valores['APCodigo']);
            foreach($Etapa  as  $camposEtp=>$valoresEtp)
            {
                $html[$i] .=$valoresEtp['GrupoCodigo'] = $objAp->preencheZero("E", 3, $valoresEtp['GrupoCodigo']) . "-" . $valoresEtp['GrupoNome'] .' ('. $valoresEtp['Login'] .')'. "</BR></BR>" . $valoresEtp['DtAprovacao']."</BR>". $valoresEtp['TimeAprovacao'];
            } 
            $html[$i] .= "</td>";
            $html[$i] .= "<td $CorFonte>".$valores['CodigoLoja']." - ".$valores['NomeLoja']."</td>";
            $html[$i] .= "<td $CorFonte>".$valores['DtVencimento']."</td>";
            $html[$i] .= "<td $CorFonte>".$ValorBruto."</td>";
            //Tipo de Despesa/Nota
            $html[$i] .= "<td style='display:none'><input type='hidden' value='".$valores['TpNota']."' id='tpnota'/></td>";            
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
                                 //$lnkBotao = $lnkArq;

                                 $html[$i] .= "<tr class='".$cor."'>";
                                 $html[$i] .= "<td width='95%' ><a target='_blank' href=".$AD.CAMINHO_ARQUIVOS."CAT".$lnkArq.$AD.">".$valores2['NOM']."</a></td>";
                                 $html[$i] .= "<td width='5%'  ><a href=".$AD."javascript:excluir('T0016','T0016/home&cod=".$valores['APCodigo']."&path=".$lnkArq."','T008_T055','T055_codigo','".$valores2['ARQ']."')".$AD." title='Excluir' class='excluir'></a></td>";
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
            // Detalhes, aparece em todos os status
            $html[$i] .= "<li class='ui-state-default ui-corner-all' title='Detalhes'><a href='?router=T0016/detalhe&cod=".$valores['APCodigo']."&orig=home'                                      class='ui-icon ui-icon-search'></a></li>";
            // Status de Aprovacao, Digitadas e anteriores
            if ($status == 1)
            {
                $html[$i] .= "<li class='ui-state-default ui-corner-all' title='Cancelar'                   ><a href=".$AD."javascript:cancelar('T0016','T0016/home','T008_approval','1','T008_codigo',".$valores['APCodigo'].",".$valores['CodigoEtapa'].")".$AD."     class='ui-icon ui-icon-cancel'                                  ></a></li>";
            }
            
            if(($status == 1) || ($status == 2) || ($status == 3))
            {
                $html[$i] .= "<li class='ui-state-default ui-corner-all' title='Alterar' ><a href=".$AD."?router=T0016/altera&cod=".$valores['APCodigo']."&codfor=".$valores['FornCodigo'].$AD." class='ui-icon ui-icon-pencil'></a></li>";
                $html[$i] .= "<li class='ui-state-default ui-corner-all' title='Anexar'  ><a href=".$AD."javascript:upload(".$valores['APCodigo'].")".$AD."                             class='ui-icon ui-icon-pin-s' ></a></li>";
            }
            // Status de Aprovacao
            if($status ==   1)
            {
                $html[$i] .= "<li class='ui-state-default ui-corner-all' title='Aprovar'                    ><a href=".$AD."javascript:aprovar('T0016','T0016/home','T008_T060','1','T008_codigo',".$valores['APCodigo'].",".$valores['CodigoEtapa'].",".$valores['TpNota'].")".$AD."          class='ui-icon ui-icon-check'                                   ></a></li>";                
                //$html[$i] .= "<li class='ui-state-default ui-corner-all' title='Voltar Aprovação'           ><a href=".$AD."?router=T0016/ultimas&FornCodigo=".$valores['FornCodigo'].$AD."                                                                             class='ui-icon ui-icon-arrowreturnthick-1-w'    target='_blank' ></a></li>";                
                if ($valores['StatusAp']==0)
                    $html[$i] .= "<li class='ui-state-default ui-corner-all' title='Transferir Fluxo'              ><a href='#' class='ui-icon ui-icon-transferthick-e-w transferirAP'                       ></a></li>";                                
            }            
            // Status de Aprovacao, Digitadas e posteriores
            if(($status == 1) || ($status == 2) || ($status==4))
            {
                $html[$i] .= "<li class='ui-state-default ui-corner-all' title='Imprimir'  ><a href=".$AD."?router=T0016/js.pdf&cod=".$valores['APCodigo'].$AD."                           class='ui-icon ui-icon-print'                target='_blank' ></a></li>";
            }
            
            $html[$i] .= "<li class='ui-state-default ui-corner-all' title='Últimas APs Fornecedor'  ><a href=".$AD."?router=T0016/ultimas&FornCodigo=".$valores['FornCodigo']."&Loja=".$valores['CodigoLoja'].$AD."                           class='ui-icon ui-icon-note'                target='_blank' ></a></li>";                
            $html[$i] .= "</ul>";
            $html[$i] .= "</span>";
            $html[$i] .= "</td>";
            $html[$i] .= "</tr>";

            $i++;
        }
        
        //Retorno para o jQuery
        echo json_encode($html);

    }
    
    $FilRegistros           =   $_GET['FilRegistros']           ;
    $FilAp                  =   $_GET['FilAp']                  ;
    $FilNf                  =   $_GET['FilNf']                  ;
    $FilCNPJ                =   $_GET['FilCNPJ']                ;
    $FilFornecedor          =   $_GET['FilFornecedor']          ;
    $FilVencimentoInicial   =   $_GET['FilVencimentoInicial']   ;
    $FilVencimentoFinal     =   $_GET['FilVencimentoFinal']     ;
    $FilValorInicial        =   $_GET['FilValorInicial']        ;
    $FilValorFinal          =   $_GET['FilValorFinal']          ;

    $Dlm=chr(39); // delimitador apostofre
    
    $FiltroQuery="";
    
     // monta filtros para as Querys
     if(!empty($FilAp))
       $FiltroQuery .=  ' AND ( T08.T008_codigo  = '.$FilAp.' ) ';
     if(!empty($FilNf))
       $FiltroQuery .=  ' AND ( T08.T008_nf_numero  = '.$FilNf.' ) ';
     if(!empty($FilCNPJ))
       $FiltroQuery .=  ' AND ( T26.T026_rms_cgc_cpf like '.$Dlm.'%'.$FilCNPJ.'%'.$Dlm. ') ';
     if(!empty($FilFornecedor))
       $FiltroQuery .=  ' AND ( upper(T26.T026_rms_razao_social) like upper('.$Dlm.'%'.$FilFornecedor.'%'.$Dlm. ') ) ';
     if(!empty($FilVencimentoInicial))
     {
         // formata as datas para formato do MySQL
        $FilVencimentoInicial   = $objBuscaAP->formataData($FilVencimentoInicial)   ;
        $FiltroQuery .=  ' AND ( T08.T008_nf_dt_vencto  >= '.$Dlm.$FilVencimentoInicial.$Dlm.' ) ';
     }
     if(!empty($FilVencimentoFinal))
     {
         // formata as datas para formato do MySQL
        $FilVencimentoFinal     = $objBuscaAP->formataData($FilVencimentoFinal)     ;
        $FiltroQuery .=  ' AND ( T08.T008_nf_dt_vencto  <= '.$Dlm.$FilVencimentoFinal.$Dlm.' ) ';
     }
     if(!empty($FilValorInicial) & $FilValorInicial > 0)
       $FiltroQuery .=  ' AND ( T08.T008_nf_valor_bruto  >= '.str_replace (',', '.', str_replace ('.', '', $FilValorInicial)).' ) ';
     if(!empty($FilValorFinal) & $FilValorFinal > 0)
       $FiltroQuery .=  ' AND ( T08.T008_nf_valor_bruto  <= '.str_replace (',', '.', str_replace ('.', '', $FilValorFinal)).' ) ';
     
     
    // Verifica qual o status do filtro selecionado 
    switch ($status)
    { 
        case 1:
             $Ap    = $objAp->retornaApsPendentesAprovacao($user,$FiltroQuery,$FilRegistros);
             CriaTabelaHTML($Ap, $status);
             break;
        case 2:
             $Ap    = $objAp->retornaApsDigitadas($user,$FiltroQuery,$FilRegistros);
             CriaTabelaHTML($Ap, $status);
             break;
        case 3:
             $Ap    = $objAp->retornaApsAnteriores($user,$FiltroQuery,$FilRegistros);
             CriaTabelaHTML($Ap, $status);
             break;
        case 4:
             $Ap    = $objAp->retornaApsPosteriores($user,$FiltroQuery,$FilRegistros);
             CriaTabelaHTML($Ap, $status);
             break;
        case 5:
             $Ap    = $objAp->retornaApsFinalizadas($user,$FiltroQuery,$FilRegistros);
             CriaTabelaHTML($Ap, $status);
             break;
        case 6:
             $Ap    = $objAp->retornaApsCanceladas($user,$FiltroQuery,$FilRegistros);
             CriaTabelaHTML($Ap, $status);
             break;
        case 7:
             $Ap    = $objAp->retornaApsForaPrazo($user,$FiltroQuery,$FilRegistros);                 
             CriaTabelaHTML($Ap, $status);
             break;
        case 8:
             $Ap    = $objAp->retornaTodos($user,$FiltroQuery,$FilRegistros);                 
             CriaTabelaHTML($Ap, $status);
             break;

    }

}
?>

<?php
/* -------- Controle de versões - js.busca.php --------------
 * 1.0.0 - #/#/# --> Liberada versao sem controle de versionamento
 * 1.0.1 - 13/09/2011 - Alexandre --> Alterado chamada das funcoes e recebimento de paramentros (GET) para realizar Querys do retorno das APs,
 *                      foi incluso dois parametros ($FiltroQuery,$FilRegistros) para que sejam utilizados Filtros e limitador nas Querys
 * 1.0.2 - 14/09/2011 - Alexandre --> Alterado botoes de Acoes, incluindo botao de "Ultimas Aps Fornecedor"
 * 
*/
?>


