<?php

//Instancia Classe
$objWkf         =   new models_T0016();

//Seleciona Lojas
$ListLoja       =   $objWkf->listaLojas();

//Captura Login para inserção
$user           =   $_SESSION['user'];

$data           =   date('d/m/Y H:i:s');
$tipo           =   $_GET['tipo'];
//Verifica se CNPJ não é nulo

if (!is_null($_POST['T026_rms_cgc_cpf'])
|| (!is_null($_POST['cpf_T026_rms_cgc_cpf'])))
{
    //Tabela Inserção
    $tabela         =   "T008_approval";
    $_POST['T026_nf_serie'] = strtoupper($_POST['T026_nf_serie']);
    //Remove campos do Array para inserir T008_approval
    unset ($_POST['T026_rms_cgc_cpf']);
    unset ($_POST['T026_rms_codigo']);
    unset ($_POST['T026_rms_insc_est_ident']);
    unset ($_POST['T026_rms_razao_social']);
    unset ($_POST['T026_rms_insc_mun']);
    unset ($_POST['cpf_T026_rms_cgc_cpf']);
    unset ($_POST['cpf_T026_rms_codigo']);
    unset ($_POST['cpf_T026_rms_insc_est_ident']);
    unset ($_POST['cpf_T026_rms_razao_social']);
    unset ($_POST['T026_rms_digito']);

    //VALIDANDO CAMPOS VAZIOS
    if ($_POST['T008_nf_numero'] == "")
        $_POST['T008_nf_numero'] = "null";
    if ($_POST['T026_nf_serie' == ""])
        $_POST['T026_nf_serie'] = "0";
    if ($_POST['T008_ft_numero' == ""])
        $_POST['T008_ft_numero'] = "0";

    $insere = $objWkf->inserir($tabela, $_POST);

    $codAp  = $objWkf->lastInsertId();

    $tabela = "T008_T060";
    $Etapa = $objWkf->retornaEtapaGrupo($_POST['T008_T026T059_T059_codigo']);

    foreach($Etapa as $campos=>$valores)
    {
        $array = array ( "T060_codigo"          =>  $valores['EtapaCodigo']
                       , "T008_codigo"          =>  $codAp
                       , "T008_T060_ordem"      =>  1
                       , "T008_T060_status"     =>  0
                       , "T004_login"           =>  $user);
        //inserirFluxoAp($valores['ProxEtapaCodigo'],1);
        $insere2 = $objWkf->inserir($tabela, $array);
        $insere3 = $objWkf->inserirFluxo($codigoDespesa, $valores['ProxEtapaCodigo'],2);
    }

    header('location:?router=T0016/home');

}

$GrpsUser=  $objWkf->listaWF();

?>
<!-- Busca CNPJ ou CODIGO RMS  -->
<script src="template/js/interno/T0016/busca.js"></script>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0016/home">Listar</a></li>
                <li><a href="?router=T0016/novo" class="active">Novo</a></li>
                <?php
                if (($user == 'jnova') || ($user == 'msasanto') || ($user == 'cmlima') || ($user == 'aribeiro') || ($user == 'gssilva'))
                 echo "<li><a href='?router=T0016/monitora'>Visualizar Antigas</a></li>";

                 echo "<li><a href='?router=T0016/painel'>Painel de Aprovações</a></li>";
                ?>
                <li><a href="?router=T0016/fluxo">Fluxo AP</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="cx_grps" style="display:none">
    <div id="dialog-grp" title="Grupo de Workflow">
        <p class="validateTips">Este fornecedor para esta Loja não está associado à nenhum Grupo de Workflow, selecione um grupo abaixo para associa-lo:</p>
        <form action="" id="frm_grps">
            <fieldset>
                <table>
                    <tr>
                        <td><label class="label">Grupo de Workflow</label></td>
                    </tr>
                    <tr>
                        <td>
                            <select name="T059_codigo" id="grupo" class="validate[required] form-input-text-table" style="width: 500px;" >
                                <?php foreach($GrpsUser as $campos=>$valores){                                                                                                                                                ?>
                                <option value="<?php echo $valores['COD']?>"><?php echo $valores['COD']=$objWkf->preencheZero("E",3,$valores['COD'])?> - <?php echo $valores['NOM']?></option>
                                <?php }?>
                            </select>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </form>
    </div>
</div>
<div id="cx_apnf" style="display:none">
    <div id="dialog-apnf" title="Atenção!">
        <p class="validateTips">Esta Nota foi localizada inserida em nossa base de dados para esse mesmo fornecedor, confira os dados completos da Nota Fiscal para não digita-la novamente:</p>
        <form action="" id="frm_apnf">
            <fieldset>
                <table>
                    <tr>
                        <td><label class="label">Grupo de Workflow</label></td>
                    </tr>
                </table>
            </fieldset>
        </form>
    </div>
</div>
<form action="" method="post" class="validaFormulario">
<div id="formulario" class="formulario">
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-titulo">
        <p>Dados do Fornecedor</p>
    </span>
    <span class="form-input">
        <div id="form-trocar">
            <a href="#" onClick="alternarDocumento('CNPJ')">Pessoa Jurídica</a>
            <a href="#" onClick="alternarDocumento('CPF')" >Pessoa Física  </a>
        </div>
        <!-- PESSOA JURÍDICA - CNPJ -->
        <table style="display: block;" id="pessoa_juridica">
            <tr>
                <td><label class="label">CNPJ*             </label></td>
                <td><label class="label">Cod RMS*          </label></td>
                <td><label class="label">Inscrição Estadual</label></td>
            </tr>
            <tr>
                <td>            <input type="text" name="T026_rms_cgc_cpf"         id="cnpj_for"   class="form-input-text-table" /></td>
                <td>            <input type="text" name="T026_rms_codigo"          id="rms_codigo" class="form-input-text-table" /></td>
                <td>            <input type="text" name="T026_rms_insc_est_ident"  id="ie"         class="form-input-text-table" readonly/></td>
            </tr>
            <tr>
                <td colspan="2"><label class="label">Razão Social*      </label></td>
                <td>            <label class="label">Inscrição Municipal</label></td>
            </tr>
            <tr>
                <td colspan="2"><input type="text" name="T026_rms_razao_social"     id="raz_social" class="form-input-text-table" readonly/></td>
                <td>            <input type="text" name="T026_rms_insc_mun"         id="im"         class="form-input-text-table" readonly/></td>
            </tr>
        </table>
        <!-- PESSOA JURÍDICA - CNPJ - FIM -->
        <!-- PESSOA FÍSICA - CPF -->
        <table style="display: none;" id="pessoa_fisica">
            <tr>
                <td><label class="label">CPF*    </label></td>
                <td><label class="label">Cod RMS*</label></td>
                <td></td>
            </tr>
            <tr>
                <td>            <input type="text" name="cpf_T026_rms_cgc_cpf"      id="cpf_for"        class="form-input-text-table" /></td>
                <td>            <input type="text" name="cpf_T026_rms_codigo"       id="cpf_rms_codigo" class="form-input-text-table" /></td>
            </tr>
            <tr>
                <td colspan="2"><label class="label">Razão Social*</label></td>
                <td><label class="label">RG</label></td>
            </tr>
            <tr>
                <td colspan="2"><input type="text" name="cpf_T026_rms_razao_social"    id="cpf_raz_social" class="form-input-text-table" /></td>
                <td>            <input type="text" name="cpf_T026_rms_insc_est_ident"  id="cpf_rg"         class="form-input-text-table" /></td>
            </tr>
        </table>
        <!-- PESSOA FÍSICA - CPF - FIM -->
        <span class="form-titulo">
            <p>Dados da Nota Fiscal</p>
        </span>
        <table>
            <tr>
                <td><label class="label">Nota Fiscal   </label></td>
                <td><label class="label">Série         </label></td>
                <td><label class="label">Fatura</label></td>
                <td><label class="label">Tipo da Nota</label></td>
            </tr>
            <tr>
                <td><input type="text" name="T008_nf_numero"  id="nf_num"   class="form-input-text-table"  /></td>
                <td><input type="text" name="T026_nf_serie"   id="serie"    class="form-input-text-table" /></td>
                <td><input type="text" name="T008_ft_numero"  id="fatura"   class="form-input-text-table" /></td>
                <td>
                    <select            name="T008_tp_nota"    id="tp_nota"   class="form-input-text-table">
                        <option value="0">Selecione...</option>
                        <option value="1" selected>01 - Serviços</option>
                        <option value="2">02 - Despesas</option>
                    </select>
                </td>

            </tr>
            <tr>
                <td><label class="label">Data de Emissão*    </label></td>
                <td><label class="label">Data de Recebimento*</label></td>
                <td><label class="label">Data de Vencimento    </label></td>
            </tr>
            <tr>
                <td><input type="text" name="T008_nf_dt_emiss"  id="dt_emissao"     class="validate[required,custom[date]] form-input-text-table" /></td>
                <td><input type="text" name="T008_nf_dt_receb"  id="dt_recebimento" class="validate[required,custom[date]] form-input-text-table" /></td>
                <td><input type="text" name="T008_nf_dt_vencto" id="dt_vencto"      class="form-input-text-table"  value=""/></td>
            </tr>
            <tr>
                <td><label class="label">Valor*</label></td>
<!--                <td><label class="label">Valor Liquido*</label></td>-->
                <td><label class="label">Forma de Pagamento</label></td>
            </tr>
            <tr>
                <td><input type="text" name="T008_nf_valor_bruto" id="valor_bruto"   class="validate[required] form-input-text-table" /></td>
<!--                <td><input type="text" name="T008_nf_valor_liq"   id="valor_liquido" class="validate[required] form-input-text-table" /></td>-->
                <td>
                    <select name="T008_forma_pagto"    id="frm_pgto"      class="form-input-text-table" >
                        <option value="">Selecione...</option>
                        <option value="BOLETO" selected>01 - Boleto</option>
                        <option value="DEPOSITO EM C/C">02 - Depósito em C/C</option>
                        <option value="OUTROS">03 - Outros</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label class="label">Loja Faturada*</label></td>
                <td><label class="label">N° do Contrato</label></td>
                <td><label class="label">Característica*</label></td>
            </tr>
            <tr>
                <td>
                    <select name="T008_T026T059_T006_codigo" id="loja" class="validate[required] form-input-text-table loja">
                        <option value="">Selecione...</option>
                    <?php foreach($ListLoja as $campos=>$valores){ ?>
                        <option value='<?php echo $valores['LCODI']; ?>'><?php echo $valores['LCODI']; ?> - <?php echo ($valores['LNOME']); ?></option>
                    <?php }?>
                    </select>
                </td>
                <td><input type="text" name="T008_num_contrato" id="num_cont" class="form-input-text-table" /></td>
                <td>
                    <div id="radio">
                            <input type="radio" id="radio1" name="T008_tp_despesa" value="1"                   class="validate[required]" /><label for="radio1">Eventual</label>
                            <input type="radio" id="radio2" name="T008_tp_despesa" value="2"                   class="validate[required]" /><label for="radio2">Por demanda</label>
                            <input type="radio" id="radio3" name="T008_tp_despesa" value="3" checked="checked" class="validate[required]" /><label for="radio3">Regular</label>
                    </div>
                </td>
            </tr>
        </table>
        <span class="form-titulo">
            <p>Grupos de Workflow</p>
        </span>
        <table>
            <tr>
                <td><label class="label">Grupo de Workflow</label></td>
            </tr>
            <tr>
                <td class="acoes" style="width:500px;">
                    <select name="T008_T026T059_T059_codigo" id="workflow" class="validate[required] form-input-text-table" style="width:500px;"></select>
                </td>
                <td style="text-align:center">
                    <span class="form-input">
                            <input  type="button" 
                                    id="adicionarGpWk" 
                                    onmouseover ='show_tooltip_alert("","Clique aqui para adicionar um Grupo de Workflow", true);tooltip.pnotify_display();' 
                                    onmousemove ='tooltip.css({"top": event.clientY+12, "left": event.clientX+12});' 
                                    onmouseout  ='tooltip.pnotify_remove();'
                                    value ="Adicionar Grupos"/>
                    </span>
                </td>
            </tr>
        </table>
        <span class="form-titulo">
            <p>Informações / Descrições</p>
        </span>
        
    </span>
</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Detalhes</a></li>
        <li><a href="#tabs-2">Justificativas</a></li>
        <li><a href="#tabs-3">Instruções</a></li>
        <li><a href="#tabs-4">Controladoria</a></li>
    </ul>
    <div id="tabs-1">
    <span class="form-input">
        <table>
            <tr>
                <td><label class="label">Detalhes (detalhamentos do serviço contratado, competencia ou período de execução, mencionar anexos que seguem, e demais conteúdos)</label></td>
            </tr>
            <tr>
                <td><textarea name="T008_desc"                id="desc" class="validate[required] textarea-table" cols="" rows="" ></textarea></td>
            </tr>
        </table>
    </span>
    </div>
    <div id="tabs-2">
    <span class="form-input">
        <table>
            <tr>
                <td><label class="label">Justificativas/Considerações relevantes à contratação:</label></td>
            </tr>
            <tr>
                <td><textarea name="T008_justificativa"       id="just" class="vtextarea-table" cols="" rows="" ></textarea></td>
            </tr>
        </table>
    </span>
    </div>
    <div id="tabs-3">
    <span class="form-input">
        <table>
            <tr>
                <td><label class="label">Instruções p/ Controladoria/Financeiro</label></td>
            </tr>
            <tr>
                <td><textarea name="T008_inst_controladoria"  id="inst" class="textarea-table" cols="" rows="" ></textarea></td>
            </tr>
        </table>
    </span>
    </div>
    <div id="tabs-4">
    <span class="form-input">
    <table>
        <tr>
            <td><label class="label">Espaço reservado à controladoria (agenda, numero, serie, data de agenda, conta contábil, controles internos, etc.)</label></td>
        </tr>
        <tr>
            <td><textarea name="T008_dados_controladoria" id="espa" class="textarea-table" cols="" rows="" ></textarea></td>
        </tr>
    </table>
    </span>
    </div>
</div>
<div id="formulario" class="formulario">
    <span class="form-input">
        <div class="form-inpu-botoes">
            <input type="hidden"  name="T026_rms_digito"    value=""                                                />
            <input type="hidden"  name="T008_status"        value="0"                                               />
            <input type="hidden"  name="T008_dt_elaboracao" value="<?php echo $data; ?>"                            />
            <input type="hidden"  name="T026_codigo"        value=""  id="CodForn"                                  />
            <input type="hidden"  name="T008_T026T059_T026_codigo"        value=""          id="CodFornWkf"         />
            <input type="hidden"  name="T004_login"         value="<?php echo $user;?>"                             />
            <input type="hidden"  name="T008_T026T059_T061_codigo"        value="1"         id="processo"           />
            <input type="submit"                            value="Gerar AP"                id="P0016_btn_criar"    />
        </div>
    </span>
</div>
</form>
