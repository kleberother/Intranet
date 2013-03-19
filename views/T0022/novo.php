<?php
//Criando objeto
$objT022 = new models_T0022();

//Select das lojas
$Loja    =  $objT022->listaLojas();

//Seleciona o usuário logado
$user = $_SESSION["user"];

?>
<!-- jQuery-->
<script type="text/javascript" src="template/js/interno/T0022/T0022.js"></script>
<!--<script type="text/javascript" src="template/js/interno/T0022/calculo.js"></script>-->
<div id="dialog-finalizar" title="Mensagem!" style="display:none">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja finalizar esta pesquisa?<br><br>(Após finalizar, não será possivel alterar mais os dados dessa pesquisa)</p>
</div>
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
<form action="" method="" id="formCad">
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">D´Avó</a></li>
        <li><a href="#tabs-2">Concorrência</a></li>
    </ul>
    <div id="tabs-1">
<div id="mestre">
    <div id="mest-quadrado-left">
        <div id="formulario">
            <span class="form-input">
                <table>
                    <tr>
                        <td><label class="label">Posto:*          </label></td>
                    </tr>
                    <tr>
                        <td>
                            <select class="validate[required] form-input-text-table" name="loja" id="loja">
                                <option value="">Selecione...</option>
                                <?php
                                    foreach($Loja as $campo=>$valores)
                                    {
                                ?>
                                     <option value="<?php echo $valores['Codigo']; ?>"><?php echo $valores['Nome']; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label class="label">Pesquisado por:*</label></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="usuario"  id="usuario" value="<?php echo $user; ?>"   class="form-input-text-table" readonly="readonly" /></td>
                    </tr>
                    <tr>
                        <td><label class="label">Data:*          </label></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="data"  id="data"   class="form-input-text-table" value="<?php echo $data_atual  = date("d/m/Y"); ?>" /></td>
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
                                <td><input name="CustoGC" type="text" id="custo_gc"  size="3" /></td>
                                <td><input name="CustoGA" type="text" id="custo_ga"  size="3" /></td>
                                <td><input name="CustoEC" type="text" id="custo_ec"  size="3" /></td>
                                <td><input name="CustoEA" type="text" id="custo_ea"  size="3" /></td>
                                <td><input name="CustoDI" type="text" id="custo_di"  size="3" /></td>
                                <td><input name="CustoGN" type="text" id="custo_gn"  size="3" /></td>
                            </tr>
                            <tr class="mest-quad-list-tabl-tr-input">
                                <td style="text-align: right;">Venda (R$)</td>
                                <td><input name="VendaGC" type="text" id="venda_gc"  size="3" /></td>
                                <td><input name="VendaGA" type="text" id="venda_ga"  size="3" /></td>
                                <td><input name="VendaEC" type="text" id="venda_ec"  size="3" /></td>
                                <td><input name="VendaEA" type="text" id="venda_ea"  size="3" /></td>
                                <td><input name="VendaDI" type="text" id="venda_di"  size="3" /></td>
                                <td><input name="VendaGN" type="text" id="venda_gn"  size="3" /></td>
                            </tr>
                            <tr class="mest-quad-list-tabl-tr-input">
                                <td style="text-align: right;">Margem (%)</td>
                                <td><input name="MargemGC" type="text" id="margem_gc"  size="4" readonly="readonly" /></td>
                                <td><input name="MargemGA" type="text" id="margem_ga"  size="4" readonly="readonly" /></td>
                                <td><input name="MargemEC" type="text" id="margem_ec"  size="4" readonly="readonly" /></td>
                                <td><input name="MargemEA" type="text" id="margem_ea"  size="4" readonly="readonly" /></td>
                                <td><input name="MargemDI" type="text" id="margem_di"  size="4" readonly="readonly" /></td>
                                <td><input name="MargemGN" type="text" id="margem_gn"  size="4" readonly="readonly" /></td>
                            </tr>
                        </tbody>
                </table>
            </span>
        </div>
    </div>
    <div id="conteudo" class="clear">
    <span class="form-input">
        <div class="form-inpu-botoes">
            <button type="button" class="btn_importar">Importar dados da última pesquisa</button>
            <button type="button" class="btn_proximo">Salvar e Continuar</button>
        </div>
    </span>
    </div>
</div>
    </div>
        <div id="tabs-2">
            <div id="conteudo">
                <span class="lista_itens">
                    <table class="ui-widget ui-widget-content tab_row">
                            <thead>
                                <tr class="ui-widget-header ">
                                    <th>Dados do Posto Concorrente                      </th>
                                    <th width="36px" title="Gasolina Comum" >GC         </th>
                                    <th width="36px" title="Gasolina Aditivada">GA      </th>
                                    <th width="36px" title="Etanol Comum">EC            </th>
                                    <th width="36px" title="Etanol Aditivado">EA        </th>
                                    <th width="36px" title="Diesel">DIE                 </th>
                                    <th width="36px" title="Gás Natural Veicular">GNV   </th>
                                    <th width="49px" ></th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                <tr class="mest-quad-list-tabl-tr-input linha">
                                    <input type="hidden" name="ItemId[]"        class="ItemId"  />
                                    <td>
                                        <select  name="posto[]" class="posto" style="width: 450px;">
<!--                                            <option value="" selected>Selecione</option>-->
                                        </select>
                                    </td>
                                    <td><input type="text"  name="gc[]"         class="gc"         size="1"  /></td>
                                    <td><input type="text"  name="ga[]"         class="ga"         size="1"  /></td>
                                    <td><input type="text"  name="ec[]"         class="ec"         size="1"  /></td>
                                    <td><input type="text"  name="ea[]"         class="ea"         size="1"  /></td>
                                    <td><input type="text"  name="di[]"         class="di"         size="1"  /></td>
                                    <td><input type="text"  name="gn[]"         class="gn"         size="1"  /></td>
                                    <td><span class="lista_acoes"><ul><li class="ui-state-default ui-corner-all" title="Deletar"   ><a class="ui-icon ui-icon-minus btn_del"></a></li></ul></span></td>
                                    <td style="display:none;"><input type="hidden" name="contador" value="1" class="contador"/></td>
                                </tr>
                                <input type="hidden" name="pesquisa" class="pesquisa" />
                            </tbody>
                    </table>
                    <table class="ui-widget ui-widget-content">
                        <tbody>
                            <tr class="mest-quad-list-tabl-tr-input">
                                <td style="text-align: right;" colspan="6">Preço Médio</td>
                                <td width="36px"><input type="text" id="media_gc"  size="1" readonly="readonly" /></td>
                                <td width="36px"><input type="text" id="media_ga"  size="1" readonly="readonly" /></td>
                                <td width="36px"><input type="text" id="media_ec"  size="1" readonly="readonly" /></td>
                                <td width="36px"><input type="text" id="media_ea"  size="1" readonly="readonly" /></td>
                                <td width="36px"><input type="text" id="media_di"  size="1" readonly="readonly" /></td>
                                <td width="36px"><input type="text" id="media_gn"  size="1" readonly="readonly" /></td>
                                <td width="49px"></td>
                            </tr>
                        </tbody>
                    </table>
                    <span class="form-input">
                        <div class="form-inpu-botoes">
                            <button type="button" class="btn_add">Adicionar Linha</button>
                            <button type="button" class="btn_calc">Atualizar \ Calcular</button>
                            <button type="button" class="btn_finalizar">Finalizar</button>
                        </div>
                    </span>
                </span>
            </div>
        </div>
</div>
</form>