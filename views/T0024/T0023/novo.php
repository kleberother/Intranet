<?php
//Chama classes

//Classe para Artigos
//$objArtigo = new models_T0014();
//$Artigo    = $objArtigo->selecionaArtigo();

$user = $_SESSION['user'];

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0023/home">Listar</a></li>
                <li><a href="?router=T0023/novo" class="active">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="conteudo">
   <span id="dados">
        <form id="form-cadastro" method="post" accept-charset="iso-8859-1" action="inseri_fornecedor.php">
            <!-- PESSOA JURIDICA FORMULARIO INICIO           -->
            <table width="100%" cellspacing="5">
                <tr>
                    <td class="titulo" colspan="4">Novo Fornecedor</td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div id="pessoas">
                            <input type="radio" id="radio_jur" value="Pessoa Jurídica" name="pessoas" onClick="alternarDocumento('CNPJ')" checked="checked" /><label for="radio_jur">Pessoa Jurídica</label>
                            <input type="radio" id="radio_fis" value="Pessoa Física" name="pessoas" onClick="alternarDocumento('CPF')" /><label for="radio_fis">Pessoa Física</label>
                        </div>
                    </td>
                </tr>
            </table>
            <!-- PESSOA JURIDICA -->
            <table width="100%" cellspacing="5" style="display:block;" id="pessoa_juridica" style="margin:0px; padding: 0px;">
                <tr>
                    <td colspan="2" width="50%"><label>CNPJ*</label></td>
                    <td colspan="2" width="50%"><label>Cod RMS*</label></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="text" id="cnpj" name="cnpj" class="text ui-widget-content ui-corner-all" maxlength="18" onfocus="valida_pessoa()" /></td>
                    <td colspan="2"><input type="text" id="cod_rms" name="cod_rms" class="text ui-widget-content ui-corner-all" /></td>
                </tr>
                <tr>
                    <td colspan="2"><label>Fornecedor*</label></td>
                    <td><label>I.E.*</label></td>
                    <td><label>I.M.*</label></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="text" name="forn_cnpj" id="for" class="text ui-widget-content ui-corner-all" style="width:425px;"/></td>
                    <td><input type="text" name="ie" class="text ui-widget-content ui-corner-all" id="ie"  /></td>
                    <td><input type="text" name="im" class="text ui-widget-content ui-corner-all" id="im"  /></td>
                </tr>
            </table>
            <table width="100%" cellspacing="5" style="display:block;" id="pessoa_juridica" style="margin:0px; padding: 0px;">
                <tr>
                    <td colspan="2" width="50%"><label>CNPJ*</label></td>
<!--                    <td colspan="2" width="50%"><label>Cod RMS*</label></td>-->
                </tr>
                <tr>
                    <td colspan="2"><input type="text" id="cnpj" name="cnpj" class="text ui-widget-content ui-corner-all" maxlength="18" onblur="pesquisa(this.value,<?php $_POST['T061_codigo']?>)" onfocus="valida_pessoa()" /></td>
                    <td colspan="2"><input type="text" id="cod_rms" name="cod_rms" class="text ui-widget-content ui-corner-all"  /></td>
                </tr>
                <tr>
                    <td colspan="2"><label>Fornecedor*</label></td>
                    <td><label>I.E.*</label></td>
                    <td><label>I.M.*</label></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="text" name="forn_cnpj" id="for" class="text ui-widget-content ui-corner-all" style="width:425px;"  /></td>
                    <td><input type="text" name="ie" class="text ui-widget-content ui-corner-all" id="ie"  /></td>
                    <td><input type="text" name="im" class="text ui-widget-content ui-corner-all" id="im"  /></td>
                </tr>
            </table>
            <!-- PESSOA FISICA -->
            <table width="100%" cellspacing="5" style="display:none;" id="pessoa_fisica">
                <tr>
                    <td colspan="2" width="50%"><label>CPF*</label></td>
                    <td colspan="2" width="50%"><label>Cod RMS*</label></td>
                </tr>
                <tr>

                    <td colspan="2"><input type="text" id="cpf" name="cpf" class="text ui-widget-content ui-corner-all" maxlength="18"/></td>

                    <td colspan="2"><input type="text" id="cpf" name="cpf" class="text ui-widget-content ui-corner-all" maxlength="18" onblur="pesquisa(this.value)"/></td>
<!--                    <td colspan="2"><input type="text" id="cod_rms" name="cod_rms" class="text ui-widget-content ui-corner-all"  /></td>-->
                </tr>
                <tr>
                    <td colspan="2"><label>Fornecedor*</label></td>
                    <td colspan="2"><label>RG.</label></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="text" name="forn_cpf" id="for" class="text ui-widget-content ui-corner-all" style="width:425px;" /></td>
                    <td colspan="2"><input type="text" name="rg" class="text ui-widget-content ui-corner-all" id="rg" /></td>
                </tr>
            </table>
            <table width="100%" cellspacing="5">
                <tr>
                    <td><label>Grupo Workflow*</label></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <select name="workflow[]" id="workflow" class="text ui-widget-content ui-corner-all" multiple>
                            <option value="1">1</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div style="background:#F8F4EF; padding: 10px;">
                            <table width="100%">
                                <tr>
                                    <td><label>Descrição</label></td>
                                </tr>
                                <tr>
                                    <td><textarea id="desc" name="detalhes" rows="5" cols="50" style="width: 100%" class="text ui-widget-content ui-corner-all"></textarea></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="titulo" colspan="4">Contato</td>
                </tr>
                <tr>
                    <td colspan="2" width="50%"><label>Nome</label></td>
                    <td colspan="2" width="50%"><label>E-mail</label></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="text" id="nome_contato" name="nome_contato" class="text ui-widget-content ui-corner-all" maxlength="18"/></td>
                    <td colspan="2"><input type="text" id="email" name="email" class="text ui-widget-content ui-corner-all" maxlength="18" onblur="pesquisa(this.value)"/></td>
                </tr>
                <tr>
                    <td width="20%"><label>Endereço</label></td>
                    <td width="20%"><label>N°</label></td>
                    <td width="20%"><label>Cidade</label></td>
                    <td width="20%"><label>UF</label></td>
                </tr>
                <tr>
                    <td><input type="text" id="endereco" name="endereco" class="text ui-widget-content ui-corner-all" maxlength="18"/></td>
                    <td><input type="text" id="n_end" name="n_end" class="text ui-widget-content ui-corner-all" maxlength="18"/></td>
                    <td><input type="text" id="cidade" name="cidade" class="text ui-widget-content ui-corner-all" maxlength="18" onblur="pesquisa(this.value)"/></td>
                    <td><input type="text" id="uf" name="uf" class="text ui-widget-content ui-corner-all" maxlength="18" onblur="pesquisa(this.value)"/></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div style="background:#F8F4EF; padding: 10px;">
                            <table width="100%">
                                <tr>
                                    <td><label>Observações</label></td>
                                </tr>
                                <tr>
                                    <td><textarea id="obs" name="obs" rows="5" cols="50" style="width: 100%" class="text ui-widget-content ui-corner-all"></textarea></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="codigo" value="<?php $_REQUEST['T061_codigo']; ?>" />
                        <input type="submit" value="Enviar"/>
                    </td>
                </tr>
            </table>
        </form>
   </span>
</div>