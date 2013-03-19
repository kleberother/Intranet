<?php
//Pega parametros
$user = $_SESSION["user"];

?>
<script type="text/javascript" src="template/js/interno/T0022/calculo.js"></script>
<script type="text/javascript" src="template/js/interno/T0022/busca.js"></script>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0022/home">Listar</a></li>
                <li><a href="?router=T0022/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<form action="" method="">
<div id="mestre">
<!--    <span class="form-titulo">
        <p>Legenda: GC: Gasolina Comum - GA: Gasolina Aditivada - EC: Etanol Comum - EA: Etanol Aditivado - DIE: Diesel - GNV: Gás Natural Veicular</p>
    </span>-->
    <div id="mest-quadrado-left">
        <div id="formulario">
            <span class="form-input">
                <table>
                    <tr>
                        <td><label class="label">Posto:*          </label></td>
                    </tr>
                    <tr>
                        <td><input type="text" name=""  id=""   class="form-input-text-table" /></td>
                    </tr>
                    <tr>
                        <td><label class="label">Pesquisado por:*</label></td>
                    </tr>
                    <tr>
                        <td><input type="text" name=""  id=""   class="form-input-text-table" /></td>
                    </tr>
                    <tr>
                        <td><label class="label">Data:*          </label></td>
                    </tr>
                    <tr>
                        <td><input type="text" name=""  id="data"   class="form-input-text-table" /></td>
                    </tr>
                </table>
            </span>
        </div>
    </div>
    <div id="mest-quadrado-right">
        <div id="conteudo">
            <span class="lista_itens">
                <table class="ui-widget ui-widget-content">
                        <tbody>
                            <tr>
                                <td style="text-align: right;">             Preço de Venda</td>
                                <td width="14%" style="text-align: center;" title="Gasolina Comum">GC            </td>
                                <td width="14%" style="text-align: center;" title="Gasolina Aditivada">GA            </td>
                                <td width="14%" style="text-align: center;" title="Etanol Comum">EC            </td>
                                <td width="14%" style="text-align: center;" title="Etanol Aditivado">EA            </td>
                                <td width="14%" style="text-align: center;" title="Diesel">DIE           </td>
                                <td width="14%" style="text-align: center;" title="Gás Natural Veicular">GNV           </td>
                            </tr>
                            <tr class="mest-quad-list-tabl-tr-input">
                                <td style="text-align: right;">Custo (R$)</td>
                                <td><input type="text" id="custo_gc"  size="1" onblur="margemGC()" /></td>
                                <td><input type="text" id="custo_ga"  size="1" onblur="margemGA()" /></td>
                                <td><input type="text" id="custo_ec"  size="1" onblur="margemEC()" /></td>
                                <td><input type="text" id="custo_ea"  size="1" onblur="margemEA()" /></td>
                                <td><input type="text" id="custo_di"  size="1" onblur="margemDI()" /></td>
                                <td><input type="text" id="custo_gn"  size="1" onblur="margemGN()" /></td>
                            </tr>
                            <tr class="mest-quad-list-tabl-tr-input">
                                <td style="text-align: right;">Venda (R$)</td>
                                <td><input type="text" id="venda_gc"  size="1" onblur="margemGC()" /></td>
                                <td><input type="text" id="venda_ga"  size="1" onblur="margemGA()" /></td>
                                <td><input type="text" id="venda_ec"  size="1" onblur="margemEC()" /></td>
                                <td><input type="text" id="venda_ea"  size="1" onblur="margemEA()" /></td>
                                <td><input type="text" id="venda_di"  size="1" onblur="margemDI()" /></td>
                                <td><input type="text" id="venda_gn"  size="1" onblur="margemGN()" /></td>
                            </tr>
                            <tr class="mest-quad-list-tabl-tr-input">
                                <td style="text-align: right;">Margem (%)</td>
                                <td><input type="text" id="margem_gc"  size="4" readonly="readonly" /></td>
                                <td><input type="text" id="margem_ga"  size="4" readonly="readonly" /></td>
                                <td><input type="text" id="margem_ec"  size="4" readonly="readonly" /></td>
                                <td><input type="text" id="margem_ea"  size="4" readonly="readonly" /></td>
                                <td><input type="text" id="margem_di"  size="4" readonly="readonly" /></td>
                                <td><input type="text" id="margem_gn"  size="4" readonly="readonly" /></td>
                            </tr>
                        </tbody>
                </table>
            </span>
        </div>
    </div>
</div>
<div id="conteudo">
    <span class="lista_itens">
	<table class="ui-widget ui-widget-content tab_row">
		<thead>
                    <tr class="ui-widget-header ">
                        <th width="">#                                      </th>
                        <th width="">Distância                              </th>
                        <th>Nome                                            </th>
                        <th width="">CNPJ                                   </th>
                        <th width="">Bandeira                               </th>
                        <th>Endereço                                        </th>
                        <th width="38px" title="Gasolina Comum" >GC         </th>
                        <th width="38px" title="Gasolina Aditivada">GA      </th>
                        <th width="38px" title="Etanol Comum">EC            </th>
                        <th width="38px" title="Etanol Aditivado">EA        </th>
                        <th width="38px" title="Diesel">DIE                 </th>
                        <th width="38px" title="Gás Natural Veicular">GNV   </th>
                        <th width="32px" ></th>
                    </tr>
		</thead>
		<tbody>
                    <tr class="mest-quad-list-tabl-tr-input">
                        <td><input type="text"  name="influencia[]" id="influencia" class="influencia" size="1"  /></td>
                        <td><input type="text"  name="distancia[]"  id="distancia"  class="distancia"  size="1"  /></td>
                        <td><input type="text"  name="nome_posto[]" id="nome_posto" class="nome_posto" size="4"  /></td>
                        <td><input type="text"  name="cnpj[]"       id="cnpj"       class="cnpj"       size="15" /></td>
                        <td><input type="text"  name="bandeira[]"   id="bandeira"   class="bandeira"   size="4"  /></td>
                        <td><input type="text"  name="endereco[]"   id="endereco"   class="endereco"   size="25" /></td>
                        <td><input type="text"  name="gc[]"         id="gc"         class="gc"         size="1" onblur="mediaGC()" /></td>
                        <td><input type="text"  name="ga[]"         id="ga"         class="ga"         size="1"  /></td>
                        <td><input type="text"  name="ec[]"         id="ec"         class="ec"         size="1"  /></td>
                        <td><input type="text"  name="ea[]"         id="ea"         class="ea"         size="1"  /></td>
                        <td><input type="text"  name="di[]"         id="di"         class="di"         size="1"  /></td>
                        <td><input type="text"  name="gn[]"         id="gn"         class="gn"         size="1"  /></td>
                        <td></td>
                    </tr>
		</tbody>
	</table>
        <table class="ui-widget ui-widget-content">
            <tbody>
                <tr>
                    <td style="text-align: right;" colspan="6">Preço Médio</td>
                    <td width="37px"><input type="text" id="media_gc"  size="1" readonly="readonly" /></td>
                    <td width="37px">      </td>
                    <td width="37px">      </td>
                    <td width="37px">      </td>
                    <td width="37px">      </td>
                    <td width="37px">      </td>
                    <td width="26px">      </td>
                </tr>
            </tbody>
        </table>
        <span class="form-input">
            <div class="form-inpu-botoes">
                <button type="button" class="P0022_btn_add">Adicionar Linha</button>
            </div>
        </span>
    </span>
</div>
</form>