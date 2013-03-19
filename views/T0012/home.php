<?php
//Chama classes

$user  = $_SESSION['user'];

?>
<!-- Busca CNPJ ou CODIGO RMS  -->
<script src="template/js/interno/T0012/busca.js"></script>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0012/home" class="active">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <form action="?router=T0012/js.pdf" method="post" target="blank">
        <table>
            <tr>
                <td width="10%"><label class="label">Data              </label></td>
                <td width="15%"><label class="label">CNPJ*             </label></td>
                <td width="8%"><label class="label">Cod RMS*          </label></td>
                <td><label class="label">Razão Social*     </label></td>
                <td><label class="label">Valor das Baixas  </label></td>
            </tr>
            <tr>
                <td><input type="text" name="data"                    id="data"       class="" size="7" /></td>
                <td><input type="text" name="T026_rms_cgc_cpf"        id="cnpj_for"   class="" size="16" /></td>
                <td><input type="text" name="T026_rms_codigo"         id="rms_codigo" class="" size="5" /></td>
                <td><input type="text" name="T026_rms_razao_social"   id="raz_social" class="" size="74"/></td>
                <td><input type="text" name="total"                   id="total"      class="" /></td>
            </tr>
        </table>
        <span class="form-titulo">
            <p>Pesquisa das Baixas</p>
        </span>
        <table class="form-inpu-tab">
            <thead>
                <tr>
    <!--                    <th><label></label></th>
                    <th><label></label></th>-->
                    <th align="left"><label>Título    </label></th>
                    <th align="left"><label>Série     </label></th>
                    <th align="left"><label>Desd.     </label></th>
                    <th align="left"><label>Loja      </label></th>
                    <th align="left"><label>Agenda    </label></th>
                    <th align="left"><label>Descrição </label></th>
                    <th align="left"><label>Dt. Agenda</label></th>
                    <th align="left"><label>Dt. Venc. </label></th>
                    <th align="left"><label>Bruto     </label></th>
                    <th align="left"><label>Liquído   </label></th>
                </tr>
            </thead>
            <tbody class="tbody">
                <div class="linha">
                    <tr>
                        <td><input type="text" name="titulo[]"    class="titulo2"   size="3"  maxlength="10"                             /></td>
                        <td><input type="text" name="serie[]"     class="serie"     size="1"  maxlength="4"                              /></td>
                        <td><input type="text" name="desd[]"      class="desd"      size="1"  maxlength="2"                              /></td>
                        <td><input type="text" name="loja[]"      class="loja"      size="1"  maxlength="2"                              /></td>
                        <td><input type="text" name="agenda[]"    class="agenda"    size="4"  maxlength="3"                              /></td>
                        <td><input type="text" name="desc[]"      class="desc"      size="35" maxlength="60"                             /></td>
                        <td><input type="text" name="dt_agenda[]" class="dt_agenda" size="8"  maxlength="10" style="text-align: right;"  /></td>
                        <td><input type="text" name="dt_vencto[]" class="dt_vencto" size="8"  maxlength="10" style="text-align: right;"  /></td>
                        <td><input type="text" name="bruto[]"     class="bruto"     size="8"  maxlength="10" style="text-align: right;"  /></td>
                        <td><input type="text" name="liquido[]"   class="liquido"   size="8"  maxlength="10" style="text-align: right;"  /></td>
                        <!-- Numerador das linhas -->
                        <td style="display:none"><input type="hidden"  value="1" name="numerador" class="numerador"/></td>
                    </tr>                                        
                </div>

            </tbody>
        </table>
        <table>
            <tr>
                <td colspan="10"><label class="label">Considerações Gerais ou relevantes, justificativas, instruções para Depto. Financeiro, etc.</label></td>
            </tr>
            <tr>
                <td colspan="10"><textarea name="consi" id="consi" class="textarea-table" cols="" rows="" ></textarea></td>
            </tr>
        </table>
        <div class="form-inpu-botoes">
            <input type="submit" value="Gerar Impressão" />
        </div>
    </form>
    </span>
</div>

