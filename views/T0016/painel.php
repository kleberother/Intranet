<?php

//mostra mensagem
$msg   = $_GET["msg"];

if ($msg <> "")
   echo "<script>show_stack_bottomleft($msg);</script>";


$user         = $_SESSION['user'];
$tipo         = $_REQUEST['tipo'];
//Chama classes
//Classe para APS
$objAp        =  new models_T0016($conn);

//procura se há mais de um grupo de workflow associado ao usuário
  $dadoGrupoWF = $objAp->GruposWorkflowUsuario($user);

$msgFiltro    =  "Consulta Atual : " ;
//Classe para TIPOS DE ARQUIVOS
$TArq         =  $objAp->selecionaTipoArquivo();


//CONTADORES DAS ETAPAS

//PROVISIONADOR
$Tp3    = $objAp->retornaApsParadasEtapa(3);
$i3 = 0;
foreach($Tp3 as $campos=>$valores){
 $i3++;
}

//LANÇADOR
$Tp4    = $objAp->retornaApsParadasEtapa(4);
$i4 = 0;
foreach($Tp4 as $campos=>$valores){
 $i4++;
}

//CONFERENTE
$Tp5    = $objAp->retornaApsParadasEtapa(5);
$i5 = 0;
foreach($Tp5 as $campos=>$valores){
 $i5++;
}

//APROVADOR
$Tp6    = $objAp->retornaApsParadasEtapa(6);
$i6 = 0;
foreach($Tp6 as $campos=>$valores){
 $i6++;
}

//PRÉ-APROVADOR
$Tp7    = $objAp->retornaApsParadasEtapa(7);
$i7 = 0;
foreach($Tp7 as $campos=>$valores){
 $i7++;
}

//DIGITADA
$Tp8    = $objAp->retornaApsParadasEtapa(8);
$i8 = 0;
foreach($Tp8 as $campos=>$valores){
 $i8++;
}
//DIGITADA S/ LANÇADOR
$Tp9    = $objAp->retornaApsParadasEtapa(9);
$i9 = 0;
foreach($Tp9 as $campos=>$valores){
 $i9++;
}

$Tp10    = $objAp->retornaApsParadasEtapa(10);
$i10 = 0;
foreach($Tp10 as $campos=>$valores){
 $i10++;
}

$Tp11    = $objAp->retornaApsParadasEtapa(11);
$i11 = 0;
foreach($Tp11 as $campos=>$valores){
 $i11++;
}


$Ap    = $objAp->retornaApsParadasEtapa($tipo);
switch ($tipo)
 {

    case 3:
         $msgFiltro = $msgFiltro . "Paradas para o Provisionador Aprovar";
         break;
    case 4:
         $msgFiltro = $msgFiltro . "Paradas para o Lançador Aprovar";
         break;
    case 5:
         $msgFiltro = $msgFiltro . "Paradas para o Conferente de Impostos Aprovar";
         break;
    case 6:
         $msgFiltro = $msgFiltro . "Paradas para a Aprovação do Gestor";
         break;
    case 7:
         $msgFiltro = $msgFiltro . "Paradas em Pré-aprovações ao Gestor";
         break;
    case 8:
         $msgFiltro = $msgFiltro . "Digitadas e não aprovadas";
         break;
    case 9:
         $msgFiltro = $msgFiltro . "Digitadas e não aprovadas (s/ Lançadores)";
         break;
    case 10:
         $msgFiltro = $msgFiltro . "Finalizadas";
         break;
    case 11:
         $msgFiltro = $msgFiltro . "Canceladas";
         break;
}
?>
<!-- Caixa Dialogo Transmitir -->
<script src="template/js/interno/T0016/aprovar.js"></script>
<div id="dialog-transmissao" title="Mensagem!" style="display:none">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja aprovar esta AP?</p>
</div>
<!-- Caixa de Upload-->
<script src="template/js/interno/T0016/upload.js"></script>
<div id="dialog-upload" title="Upload" style="display:none">
	<p    class="validateTips">Selecione um tipo e um arquivo para carregar no sistema!</p>
        <span class="form-input">
	<form action="?router=T0016/upload" method="post" id="form-upload"  enctype="multipart/form-data">
	<fieldset>
                <label class="label">Tipo de Arquivo*</label>
                <select                 name="T056_codigo"  id="tp_codigo" class="form-input-select">
                <?php foreach($TArq as $campos=>$valores){?>
                    <option value="<?php echo $valores['COD']?>"><?php echo ($valores['NOM'])?></option>
                <?php }?>
                </select>
                <label class="label">Escolha o Arquivo*</label>
                <input type="file"      name="P0016_arquivo"      id="arquivo" class="form-input-text"   />
                <input type="hidden"    name="T055_nome"            value=""                             />
                <input type="hidden"    name="T055_desc"            value=""                             />
                <input type="hidden"    name="T055_dt_upload"       value=""                             />
                <input type="hidden"    name="T004_login"           value="<?php echo $user?>"           />
                <input type="hidden"    name="T057_codigo"          value=""                             />
                <input type="hidden"    name="T059_codigo"          value=""                             />
                <input type="hidden"    name="T008_codigo"          value=""      id="codap"             />
                <!-- Tipo Processo (Approval/Aprovação-->
                <input type="hidden"    name="T061_codigo"          value="1"                            />
        </fieldset>
	</form>
        </span>
</div>
<!-- FIM Caixa de Upload-->

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0016/home">Listar</a></li>
                <li><a href="?router=T0016/novo">Novo</a></li>
                <?php
                if (($user == 'jnova') || ($user == 'msasanto') || ($user == 'cmlima') || ($user == 'aribeiro') || ($user == 'gssilva'))
                 echo "<li><a href='?router=T0016/monitora'>Visualizar Antigas</a></li>";

                echo "<li><a href='?router=T0016/painel' class='active'>Painel de Aprovações</a></li>";
                ?>
                <li><a href="?router=T0016/fluxo">Fluxo AP</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Filtro</a></li>
        <li><a href="#tabs-3">Resumo</a></li>
        <li><a href="#tabs-4">Resumo por Grupo</a></li>
    </ul>
    <div id="tabs-1">
        <form action="?router=T0016/painel" method="post">
        <table class="form-inpu-tab">
            <thead>
                <tr>
                    <th><label>Selecione o Grupo</label></th>
                    <th rowspan="2" valign="middle">
                        <input type="submit" name="busca" value="Busca"/>
                    </th>
                </tr>
                <tr>
                    <td>
                        <select id="aps" name="tipo">
                            <option value="">Selecione...         </option>
<!--                        <option value="1">Aguardando minha Aprovação    </option>
                            <option value="2">Minhas digitadas / Grupos que pertenço</option>-->
                            <option value="3">Provisionador</option>
                            <option value="4">Lançador</option>
                            <option value="5">Confente de Impostos</option>
                            <option value="6">Aprovação do Gestor</option>
                            <option value="7">Pré-aprovações ao Gestor</option>
                            <option value="8">Digitadas</option>
                            <option value="9">Digitadas (s/ Lançadores)</option>
                            <option value="10">Finalizadas</option>
                            <option value="11">Canceladas</option>
                        </select>
                    </td>
                </tr>
            </thead>
        </table>
        </form>
        <form action="#">
        <table class="form-inpu-tab">
            <thead>
                <tr>
                    <th width="155px"><label>Filtro Dinâmico</label></th>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="search" value="" id="id_search" />
                    </td>
                    <td><span class="loading">Carregando...</span></td>
                </tr>
            </thead>
        </table>
        </form>
        <div id="conteudo">
            <span class="lista_itens">
                <label><h1><b><?php echo $msgFiltro;?></b></h1></label>
                <table class="ui-widget ui-widget-content">
                        <thead>
			<tr class="ui-widget-header ">
                            <th width="6%">AP N°                    </th>
                            <th width="9%">Nota Fiscal<br/>Série    </th>
                            <th width="13%">Fornecedor<br/>CNPJ/CPF </th>
                            <th width="8%">Elaborado<br/>por        </th>
                            <th width="13%">Última<br/>Etapa        </th>
                            <th>Loja Faturada                       </th>
                            <th width="8%">Vencimento               </th>
                            <th width="9%">Valor                    </th>
                            <th>Arquivos                            </th>
                            <th width="9%">Ações                    </th>
			</tr>
                        </thead>
                        <tbody>
                                <?php
                                foreach($Ap as $campos=>$valores){
                                //verifica o tipo do filtro para trazer os restulados com a posição correta do array

                                //Formatando CNPJ;
                                $cgc_cnpj          = $objAp->FormataCGCxCPF($valores['FornCNPJ']);

                                //Formatando Valor Bruto
                                $ValorBruto     = money_format('%n', $valores['ValorBruto']);
                                ?>
                                <tr class="dados">
                                        <td><?php echo $valores['APCodigo'];?></td>
                                        <td><?php echo $valores['NFNumero']."<br/>".$valores['NFSerie'];?></td>
                                        <td><?php echo $valores['FornRazaoSocial']."<br/>".$cgc_cnpj;?></td>
                                        <td><?php echo $valores['Login'];?></td>
                                        <td><?php
                                        $Etapa  = $objAp->retornaUltimaAprovacao($valores['APCodigo']);

                                        foreach($Etapa  as  $camposEtp=>$valoresEtp)
                                        {
                                            echo $valoresEtp['GrupoCodigo'] = $objAp->preencheZero("E", 3, $valoresEtp['GrupoCodigo']) . "-" . $valoresEtp['GrupoNome'] .' ('. $valoresEtp['Login'] .')'. "</BR></BR>" . $valoresEtp['DtAprovacao']."</BR>". $valoresEtp['TimeAprovacao'];
                                        }

                                        ?></td>
                                        <td><?php echo $valores['CodigoLoja']." - ".$valores['NomeLoja']; ?></td>
                                        <td><?php echo $valores['DtVencimento'];?></td>

                                        <td><?php echo $ValorBruto;?></td>
                                        <td>
                                            <table class="list-iten-arquivos">
                                            <?php $Arq = $objAp->selecionaArquivos($valores['APCodigo']); foreach($Arq  as  $campos=>$valores2){
                                                 if( $cont%2 == 0)
                                                        $cor = "line_color";
                                                 else
                                                        $cor = "";
                                                 $cont++;
                                                ?>
                                                <tr class="<?php echo $cor; ?>">
                                                    <td width="95%" ><a target="_blank" href="<?php echo CAMINHO_ARQUIVOS."CAT".$valores2['CAT']=$objAp->preencheZero("E", 4, $valores2['CAT'])."/".$arquivo=$objAp->preencheZero("E", 4, $valores2['ARQ']).".".$valores2['EXT']?>"><?php echo $valores2['NOM'];?></a></td>
                                                    <td width="5%"  ><a href="javascript:excluir('T0016','T0016/home&cod=<?php echo $valores['APCodigo']; ?>&path=<?php echo $valores2['CAT']=$objAp->preencheZero("E", 4, $valores2['CAT'])?>','T008_T055','T055_codigo','<?php echo $valores2['ARQ']?>')" title="Excluir" class="excluir"></a></td>
                                                </tr>
                                            <?php }?>
                                                <!-- Caixa Dialogo Excluir -->
                                                <div id="dialog-confirm" title="Mensagem!" style="display:none">
                                                    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja excluir este item?</p>
                                                </div>
                                            </table>
                                        </td>
                                        <td class="acoes">
                                            <span class="lista_acoes">
                                            <ul>
                                                <li class="ui-state-default ui-corner-all" title="Detalhes"  ><a href="?router=T0016/detalhe&cod=<?php echo $valores['APCodigo']?>"                                         class="ui-icon ui-icon-search"               ></a></li>
                                                <li class="ui-state-default ui-corner-all" title="Imprimir"  ><a href="?router=T0016/js.pdf&cod=<?php echo $valores['APCodigo']?>"                                             class="ui-icon ui-icon-print"                target="_blank" ></a></li>
                                                <?php if($tipo <> 4){?>
                                                <li class="ui-state-default ui-corner-all" title="Alterar"   ><a href="?router=T0016/altera&cod=<?php echo $valores['APCodigo']?>&codfor=<?php echo $valores['FornCodigo']?>"   class="ui-icon ui-icon-pencil"               ></a></li>
                                                <li class="ui-state-default ui-corner-all" title="Anexar"    ><a href="javascript:upload(<?php echo $valores['APCodigo']?>)"                                                class="ui-icon ui-icon-arrowreturnthick-1-n" ></a></li>
                                                <li class="ui-state-default ui-corner-all" title="Imprimir"  ><a href="?router=T0016/js.pdf&cod=<?php echo $valores['APCodigo']?>"                                             class="ui-icon ui-icon-print"                target="_blank" ></a></li>
                                                <?php }
                                                if(($tipo == 1) || ($tipo == 2)){?>
                                                <li class="ui-state-default ui-corner-all" title="Imprimir"  ><a href="?router=T0016/js.pdf&cod=<?php echo $valores['APCodigo']?>"                                             class="ui-icon ui-icon-print"                target="_blank" ></a></li>
                                                <?php }
                                                      if($tipo ==   1){?>
                                                <li class="ui-state-default ui-corner-all" title="Aprovar"   ><a href="javascript:aprovar('T0016','T0016/home','T008_T060','1','T008_codigo',<?php echo $valores['APCodigo'];?>,<?php echo $valores['CodigoEtapa'];?>)"   class="ui-icon ui-icon-check"         ></a></li>
                                                <?php }?>
                                            </ul>
                                            </span>
                                        </td>
                                </tr>
                                <?php }?>
                        </tbody>
                </table>
            </span>
        </div>
    </div>
    <div id="tabs-3">
        <div id="conteudo">
            <span class="lista_itens">
            <table class="ui-widget ui-widget-content" style="width:30%">
                <thead>
                    <tr class="ui-widget-header ">
                        <th width="90%">Etapa</th>
                        <th>Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Provisionador</td>
                        <td><?php echo $i3; ?></td>
                    </tr>
                    <tr>
                        <td>Lançador</td>
                        <td><?php echo $i4; ?></td>
                    </tr>
                    <tr>
                        <td>Confente de Impostos</td>
                        <td><?php echo $i5; ?></td>
                    </tr>
                    <tr>
                        <td>Aprovação do Gestor</td>
                        <td><?php echo $i6; ?></td>
                    </tr>
                    <tr>
                        <td>Pré-aprovações ao Gestor</td>
                        <td><?php echo $i7; ?></td>
                    </tr>
                    <tr>
                        <td>Digitadas</td>
                        <td><?php echo $i8; ?></td>
                    </tr>
                    <tr>
                        <td>Digitadas (s/ Lançador)</td>
                        <td><?php echo $i9; ?></td>
                    </tr>
                    <tr>
                        <td>Finalizadas</td>
                        <td><?php echo $i10; ?></td>
                    </tr>
                    <tr>
                        <td>Canceladas</td>
                        <td><?php echo $i11; ?></td>
                    </tr>
                </tbody>
            </table>
            </span>
        </div>
    </div>
    <div id="tabs-4">
        <div id="conteudo">
            <span class="lista_itens">
<!--                <h1><a href="?router=T0016/resumodetalhe">Link</a></h1>-->
                <table class="ui-widget ui-widget-content" style="width:100%">
                    <thead>
                        <tr class="ui-widget-header ">
                            <th>Grupo</th>
                            <th>Quantidade</th>
                            <th>Próximo Grupo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $RetornaGrupos = $objAp->RetornaQtdeGrupos();
                        foreach($RetornaGrupos as $campos=>$valores){
                        $Grupo = $valores['Grupo'];
                            ?>

                        <tr>
                            <td><?php echo $Grupo = $objAp->preencheZero("E", 3, $Grupo)." - ". $valores['Nome']?></td>
                            <td><?php echo $valores['Qtde']?></td>
                            <td><?php echo $valores['ProxGrupo'] = $objAp->preencheZero("E", 3, $valores['ProxGrupo'])." - ".$valores['ProxNome']?></td>
                            <td>
                                <span class="lista_acoes">
                                    <ul>
                                        <li class="ui-state-default ui-corner-all" title="Detalhes"  ><a href="?router=T0016/resumodetalhe&cod=<?php echo $valores['Grupo']?>"                                         class="ui-icon ui-icon-search"               ></a></li>
                                        <li class="ui-state-default ui-corner-all" title="Imprimir"  ><a href="?router=T0016/js.pdf&cod=<?php echo $valores['APCodigo']?>"                                             class="ui-icon ui-icon-print"                target="_blank" ></a></li>
                                    </ul>
                                </span>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </span>
        </div>
    </div>
</div>
