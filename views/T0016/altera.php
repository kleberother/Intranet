<!--<script src='template/js/interno/mensagens.js'></script>-->
<?php

$cod        = $_GET["cod"];
$codfor     = $_GET["codfor"];
$tabela     = "T008_approval";
//$msg        = $_GET["msg"];

//mostra mensagem
//if (!empty($msg))
//   echo "<script>show_stack_bottomleft($msg);</script>";


//Instancia Classe
 $objAP     = new models_T0016();
 $ap        = $objAP->selecionaAPDF($cod);
 $GrpWkf    = $objAP->selecionaGrupofkw($codfor);

 //Seleciona Lojas
$ListLoja   =   $objAP->listaLojas();

//Captura Login para inserção
$user       =   $_SESSION['user'];


if(!is_null($_POST['T008_codigo']))
{

    //Trata CNPJ e CPF
    $_POST['T026_rms_cgc_cpf']      =   $objAP->retiraMascara($_POST['T026_rms_cgc_cpf']);
    $_POST['T026_rms_cgc_cpf']      =   $objAP->preencheZero("E", 14, $_POST['T026_rms_cgc_cpf']);
    $_POST['cpf_T026_rms_cgc_cpf']  =   $objAP->retiraMascara($_POST['cpf_T026_rms_cgc_cpf']);
    $_POST['cpf_T026_rms_cgc_cpf']  =   $objAP->preencheZero("E", 14, $_POST['cpf_T026_rms_cgc_cpf']);
    
    //busca fornecedor
    $Forn = $objAP->selecionaForn($_POST['T026_rms_cgc_cpf']);
    
    foreach($Forn as $campos=>$valores2)
        {
            $codForn = $valores2['COD'];
        }

    if(isset($codForn))
    {
        //Tabela Inserção
        $tabela         =   "T008_approval";

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
        unset ($_POST['T008_codigo']);

        $_POST['T026_codigo']       =   $codForn;
        $_POST['T008_T026T059_T026_codigo']    =   $codForn;
        
        //VALIDANDO CAMPOS VAZIOS
        if ($_POST['T008_nf_numero'] == "")
            $_POST['T008_nf_numero'] = "null";
        if ($_POST['T026_nf_serie' == ""])
            $_POST['T026_nf_serie'] = "0";
        if ($_POST['T008_ft_numero' == ""])
            $_POST['T008_ft_numero'] = "0";        
    }

    
    $delim  =        "T008_codigo = ".$cod;

    $altera = $objAP->altera($tabela,$_POST,$delim);

    if ($objAP)
    {
        //echo $altera;
        //$msg = "3";
        //header('location:?router=T0016/home&msg='.$msg);
        header('location:?router=T0016/home');
    }
    else
    {
        //$msg = "4";
        header('location:?router=T0016/home&msg='.$msg);
    }
}

?>
<!-- Busca CNPJ ou CODIGO RMS  -->
<script src="template/js/interno/T0016/busca.js"></script>
<script>
$(function(){
//    $("#loja").live("load",(function(){
        var ap    =   $("#T008_codigo").val();
        var tipo    =   4;
        $.get("?router=T0016/js.busca&ap="+ap+"&tipo="+tipo, function(campos){
            $("#workflow").html(campos);
        });
//    }))
})
</script>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0016/home" class="active">Listar</a></li>
                <li><a href="?router=T0016/novo">Novo</a></li>
                <?php
                if (($user == 'jnova') || ($user == 'msasanto') || ($user == 'cmlima') || ($user == 'aribeiro') || ($user == 'gssilva'))
                 echo "<li><a href='?router=T0016/monitora'>Visualizar Antigas</a></li>";

                if (($user == 'rrocha') || ($user == 'fcolivei') || ($user == 'msasanto') || ($user == 'cmlima') || ($user == 'ralfieri') || ($user == 'rcsilva') || ($user == 'lolive') || ($user == 'ctlima') || ($user == 'mlsilva') || ($user == 'rcsouza'))
                 echo "<li><a href='?router=T0016/painel'>Painel de Aprovações</a></li>";
                ?>
                <li><a href="?router=T0016/fluxo">Fluxo AP</a></li>
            </ul>
        </span>
    </div>
</div>
<?php foreach($ap as $campos=>$valores){

$dt_emissao        = $valores['P0016_T008_DTE'];
$val_emi           = explode(" ",$dt_emissao);
$date_emi          = explode("-",$val_emi[0]);
$dt_emissao_format = $date_emi[2]."/".$date_emi[1]."/".$date_emi[0];

$dt_recebimento    = $valores['P0016_T008_DTR'];
$val_rec           = explode(" ",$dt_recebimento);
$date_rec          = explode("-",$val_rec[0]);
$dt_receb_format = $date_rec[2]."/".$date_rec[1]."/".$date_rec[0];

$dt_vencimento     = $valores['P0016_T008_DTV'];
$val_ven           = explode(" ",$dt_vencimento);
$date_ven          = explode("-",$val_ven[0]);
$dt_vencto_format  = $date_ven[2]."/".$date_ven[1]."/".$date_ven[0];

?>
<form action="" method="post">
    <input type="hidden"    id="T008_codigo"  value="<?php echo $valores['P0016_T008_COD'];?>"/>
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
                <td>            <input type="text" name="T026_rms_cgc_cpf"         id="cnpj_for"   class="form-input-text-table" value="<?php echo $valores['P0016_T026_CGC'];?>" /></td>
                <td>            <input type="text" name="T026_rms_codigo"          id="rms_codigo" class="form-input-text-table" value="<?php echo $valores['P0016_T026_COD']."-".$valores['P0016_T026_DIG'];?>" readonly /></td>
                <td>            <input type="text" name="T026_rms_insc_est_ident"  id="ie"         class="form-input-text-table" value="<?php echo $valores['P0016_T026_INE'];?>" readonly/></td>
            </tr>
            <tr>
                <td colspan="2"><label class="label">Razão Social*      </label></td>
                <td>            <label class="label">Inscrição Municipal</label></td>
            </tr>
            <tr>
                <td colspan="2"><input type="text" name="T026_rms_razao_social"     id="raz_social" class="form-input-text-table" value="<?php echo $valores['P0016_T026_RAZ'];?>" readonly/></td>
                <td>            <input type="text" name="T026_rms_insc_mun"         id="im"         class="form-input-text-table" value="<?php echo $valores['P0016_T026_INM'];?>" readonly /></td>
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
                <td>            <input type="text" name="cpf_T026_rms_cgc_cpf"      id="cpf_for"        class="form-input-text-table" value="<?php echo $valores['P0016_T026_CGC'];?>"  /></td>
                <td>            <input type="text" name="cpf_T026_rms_codigo"       id="cpf_rms_codigo" class="form-input-text-table" value="<?php echo $valores['P0016_T026_COD']."-".$valores['P0016_T026_DIG'];?>" readonly /></td>
            </tr>
            <tr>
                <td colspan="2"><label class="label">Razão Social*</label></td>
                <td><label class="label">RG</label></td>
            </tr>
            <tr>
                <td colspan="2"><input type="text" name="cpf_T026_rms_razao_social"    id="cpf_raz_social" class="form-input-text-table" value="<?php echo $valores['P0016_T026_RAZ'];?>" readonly /></td>
                <td>            <input type="text" name="cpf_T026_rms_insc_est_ident"  id="cpf_rg"         class="form-input-text-table" value="<?php echo $valores['P0016_T026_INM'];?>" readonly /></td>
            </tr>
        </table>
        <!-- PESSOA FÍSICA - CPF - FIM -->
        <span class="form-titulo">
            <p>Dados da Nota Fiscal</p>
        </span>
        <table>
            <tr>
                <td><label class="label">Código*</label></td>
            </tr>
            <tr>
                <td><input type="text" name="T008_codigo" id="cod" class="form-input-text-table" value="<?php echo $cod;?>" readonly /></td>
            </tr>
            <tr>
                <td><label class="label">Nota Fiscal*   </label></td>
                <td><label class="label">Série*         </label></td>
                <td><label class="label">N° da Fatura*</label></td>
            </tr>
            <tr>
                <td><input type="text" name="T008_nf_numero" id="nf_num" class="form-input-text-table" value="<?php echo $valores['P0016_T008_NNF'];?>" /></td>
                <td><input type="text" name="T026_nf_serie"  id="serie"  class="form-input-text-table" value="<?php echo $valores['P0016_T026_SER'];?>" /></td>
                <td><input type="text" name="T008_ft_numero"  id="fatura"  class="form-input-text-table" value="<?php echo $valores['P0016_T008_FAT'];?>" /></td>

            </tr>
            <tr>
                <td><label class="label">Data de Emissão*    </label></td>
                <td><label class="label">Data de Recebimento*</label></td>
                <td><label class="label">Data de Vencimento*    </label></td>
            </tr>
            <tr>
                <td><input type="text" name="T008_nf_dt_emiss"  id="dt_emissao"     class="form-input-text-table" value="<?php echo $dt_emissao_format;?>" /></td>
                <td><input type="text" name="T008_nf_dt_receb"  id="dt_recebimento" class="form-input-text-table" value="<?php echo $dt_receb_format;?>" /></td>
                <td><input type="text" name="T008_nf_dt_vencto" id="dt_vencto"      class="form-input-text-table" value="<?php echo $dt_vencto_format;?>" /></td>
            </tr>
            <tr>
                <td><label class="label">Valor Bruto*</label></td>
<!--                <td><label class="label">Valor Liquido*</label></td>-->
                <td><label class="label">Forma de Pagamento</label></td>
            </tr>
            <tr>
                <td><input type="text" name="T008_nf_valor_bruto" id="valor_bruto"   class="form-input-text-table" value="<?php echo $valores['P0016_T008_VAB'];?>" /></td>
<!--                <td><input type="text" name="T008_nf_valor_liq"   id="valor_liquido" class="form-input-text-table" value="<?php //echo $valores['P0016_T008_VAL'];?>" /></td>-->
                <td><input type="text" name="T008_forma_pagto"    id="frm_pgto"      class="form-input-text-table" value="<?php echo $valores['P0016_T008_FPA'];?>" /></td>
            </tr>
            <tr>
                <td><label class="label">Loja Faturada*</label></td>
                <td><label class="label">N° do Contrato</label></td>
                <td><label class="label">Característica*</label></td>
            </tr>
            <tr>
                <td>
                    <select name="T008_T026T059_T006_codigo" id="loja" class="form-input-text-table" disabled="disabled">
                        <option value='<?php echo $valores['P0016_T006_COD']; ?>'><?php echo $valores['P0016_T006_COD']; ?> - <?php echo ($valores['P0016_T006_NOM']); ?></option>
                    <?php foreach($ListLoja as $campos=>$valoresLoj){ ?>
                        <option value='<?php echo $valoresLoj['LCODI']; ?>'><?php echo $valoresLoj['LCODI']; ?> - <?php echo ($valoresLoj['LNOME']); ?></option>
                    <?php }?>
                    </select>
                </td>
                <td><input type="text" name="T008_num_contrato" id="num_cont" class="form-input-text-table" value="<?php echo $valores['P0016_T008_NCO'];?>" /></td>
                <td>
                <?php

                if ($valores['P0016_T008_TDE'] == 1)
                {
                ?>
                    <div id="radio">
                            <input type="radio" id="radio1" name="T008_tp_despesa" value="1" checked="checked" /><label for="radio1">Eventual</label>
                            <input type="radio" id="radio2" name="T008_tp_despesa" value="2"                   /><label for="radio2">Por demanda</label>
                            <input type="radio" id="radio3" name="T008_tp_despesa" value="3"                   /><label for="radio3">Regular</label>
                    </div>
                <?php
                }
                else if ($valores['P0016_T008_TDE'] == 2)
                {
                ?>
                    <div id="radio">
                            <input type="radio" id="radio1" name="T008_tp_despesa" value="1"                   /><label for="radio1">Eventual</label>
                            <input type="radio" id="radio2" name="T008_tp_despesa" value="2" checked="checked" /><label for="radio2">Por demanda</label>
                            <input type="radio" id="radio3" name="T008_tp_despesa" value="3"                   /><label for="radio3">Regular</label>
                    </div>
                <?php
                }
                else
                {
                ?>
                    <div id="radio">
                            <input type="radio" id="radio1" name="T008_tp_despesa" value="1"                   /><label for="radio1">Eventual</label>
                            <input type="radio" id="radio2" name="T008_tp_despesa" value="2"                   /><label for="radio2">Por demanda</label>
                            <input type="radio" id="radio3" name="T008_tp_despesa" value="3" checked="checked" /><label for="radio3">Regular</label>
                    </div>
                <?php
                }
                ?>
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
                <td>
                    <select name="T008_T026T059_T059_codigo" id="workflow" class="form-input-text-table" style="width:500px;" disabled="disabled">
                        <option value='<?php echo $valoresWF['P0016_T059_COD']; ?>'><?php echo $valoresWF['P0016_T059_COD']; ?> - <?php echo ($valoresWF['P0016_T059_NOM']); ?></option>
                    </select>
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
                <td><textarea name="T008_desc"                id="desc" class="textarea-table" cols="" rows="" ><?php echo $valores['P0016_T008_DES'];?></textarea></td>
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
                <td><textarea name="T008_justificativa"       id="just" class="textarea-table" cols="" rows="" ><?php echo $valores['P0016_T008_JUS'];?></textarea></td>
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
                <td><textarea name="T008_inst_controladoria"  id="inst" class="textarea-table" cols="" rows="" ><?php echo $valores['P0016_T008_INS'];?></textarea></td>
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
            <td><textarea name="T008_dados_controladoria" id="espa" class="textarea-table" cols="" rows="" ><?php echo $valores['P0016_T008_CON'];?></textarea></td>
        </tr>
    </table>
    </span>
    </div>
</div>
<div id="formulario" class="formulario">
    <span class="form-input">
        <div class="form-inpu-botoes">
            <input type="hidden"  name="T026_rms_digito"    value=""                                />
<!--            <input type="hidden"  name="T004_usu_aprova1"   value=""                                />
            <input type="hidden"  name="T008_dt_aprova1"    value=""                                />
            <input type="hidden"  name="T004_usu_aprova2"   value=""                                />
            <input type="hidden"  name="T008_dt_aprova2"    value=""                                />
            <input type="hidden"  name="T004_ctrl_lancto"   value=""                                />
            <input type="hidden"  name="T008_dt_lancto"     value=""                                />
            <input type="hidden"  name="T004_ctrl_aprova"   value=""                                />
            <input type="hidden"  name="T008_dt_aprova"     value=""                                />-->
<!--        <input type="hidden"  name="T026_codigo"        value=""                                />
            <input type="hidden"  name="T008_T026T059_T026_codigo"     value=""                                />-->
<!--        <input type="hidden"  name="T004_login"         value="<?php echo $user;?>"             />-->
            <input type="hidden"  name="T008_T026T059_T061_codigo"        value="1"                               />
            <input type="submit"                            value="Alterar"    id="P0016_btn_criar"/>
        </div>
    <?php }?>
    </span>
</div>
</form>
