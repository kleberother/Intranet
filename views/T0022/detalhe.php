<?php
//Criando objeto
$objT022 = new models_T0022();

//Select das lojas
$cod                   =   $_REQUEST['cod'];
$PesquisaDavo          =   $objT022->retornaPesquisaCompleta($cod);
$PesquisaConcorrente   =   $objT022->retornaPesquisaConcorrente($cod);
$i                     =   0;

//Seleciona o usuário logado
$user = $_SESSION["user"];

?>
<script type="text/javascript" src="template/js/interno/T0022/detalhe.js"></script>
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
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">D´Avó</a></li>
        <li><a href="#tabs-2">Concorrência</a></li>
    </ul>
    <div id="tabs-1">
<div id="mestre">
    <?php
    foreach($PesquisaDavo as $campos=>$valores)
    {
    ?>
    <div id="mest-quadrado-left">
        <div id="formulario">
            <span class="form-input">
                <table>
                    <tr>
                        <td><label class="label">Posto:</label></td>
                    </tr>
                    <tr>
                        <td><?php echo $valores['NomeLoja']; ?></td>
                    </tr>
                    <tr>
                        <td><label class="label">Pesquisado por:</label></td>
                    </tr>
                    <tr>
                        <td><?php echo $valores['NomeUsuario']; ?></td>
                    </tr>
                    <tr>
                        <td><label class="label">Data:</label></td>
                    </tr>
                    <tr>
                        <td><?php echo $valores['DataPesquisa']; ?></td>
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
                                <td width="14%" style="text-align: center;" title="Gasolina Comum">GC       </td>
                                <td width="14%" style="text-align: center;" title="Gasolina Aditivada">GA   </td>
                                <td width="14%" style="text-align: center;" title="Etanol Comum">EC         </td>
                                <td width="14%" style="text-align: center;" title="Etanol Aditivado">EA     </td>
                                <td width="14%" style="text-align: center;" title="Diesel">DIE              </td>
                                <td width="14%" style="text-align: center;" title="Gás Natural Veicular">GNV</td>
                            </tr>
                            <tr class="mest-quad-list-tabl-tr-input">
                                <td style="text-align: right;">Custo (R$)</td>
                                <td><?php echo str_replace(".",",",$valores['CustoGC']); ?></td>
                                <td><?php echo str_replace(".",",",$valores['CustoGA']); ?></td>
                                <td><?php echo str_replace(".",",",$valores['CustoEC']); ?></td>
                                <td><?php echo str_replace(".",",",$valores['CustoEA']); ?></td>
                                <td><?php echo str_replace(".",",",$valores['CustoDI']); ?></td>
                                <td><?php echo str_replace(".",",",$valores['CustoGN']); ?></td>
                            </tr>
                            <tr class="mest-quad-list-tabl-tr-input">
                                <td style="text-align: right;">Venda (R$)</td>
                                <td><?php echo str_replace(".",",",$valores['VendaGC']); ?></td>
                                <td><?php echo str_replace(".",",",$valores['VendaGA']); ?></td>
                                <td><?php echo str_replace(".",",",$valores['VendaEC']); ?></td>
                                <td><?php echo str_replace(".",",",$valores['VendaEA']); ?></td>
                                <td><?php echo str_replace(".",",",$valores['VendaDI']); ?></td>
                                <td><?php echo str_replace(".",",",$valores['VendaGN']); ?></td>
                            </tr>
                            <tr class="mest-quad-list-tabl-tr-input">
                                <td style="text-align: right;">Margem (%)</td>
                                <td><?php echo str_replace(".",",",$valores['MargemGC']); ?></td>
                                <td><?php echo str_replace(".",",",$valores['MargemGA']); ?></td>
                                <td><?php echo str_replace(".",",",$valores['MargemEC']); ?></td>
                                <td><?php echo str_replace(".",",",$valores['MargemEA']); ?></td>
                                <td><?php echo str_replace(".",",",$valores['MargemDI']); ?></td>
                                <td><?php echo str_replace(".",",",$valores['MargemGN']); ?></td>
                            </tr>
                        </tbody>
                </table>
            </span>
        </div>
    </div>
    <?php
    }
    ?>
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
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                <?php
                                foreach($PesquisaConcorrente as $campos=>$valores)
                                {
                                ?>
                                <tr class="mest-quad-list-tabl-tr-input linha">
                                    <td><?php echo $valores['NomePosto']; ?></td>
                                    <td class="gc_valor"><?php echo $valores['ValorGC'] ?></td>
                                    <td class="ga_valor"><?php echo $valores['ValorGA'] ?></td>
                                    <td class="ec_valor"><?php echo $valores['ValorEC'] ?></td>
                                    <td class="ea_valor"><?php echo $valores['ValorEA'] ?></td>
                                    <td class="di_valor"><?php echo $valores['ValorDI'] ?></td>
                                    <td class="gn_valor"><?php echo $valores['ValorGN'] ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                    </table>
                    <table class="ui-widget ui-widget-content">
                        <tbody>
                            <tr class="mest-quad-list-tabl-tr-input">
                                <td style="text-align: right;" colspan="6">Preço Médio</td>
                                <td width="36px" class="gc_media"></td>
                                <td width="36px" class="ga_media"></td>
                                <td width="36px" class="ec_media"></td>
                                <td width="36px" class="ea_media"></td>
                                <td width="36px" class="di_media"></td>
                                <td width="36px" class="gn_media"></td>
                            </tr>
                        </tbody>
                    </table>
                </span>
            </div>
        </div>
</div>

