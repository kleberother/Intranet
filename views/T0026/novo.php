<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 31/01/2012 por Rodrigo Alfieri
 * Descrição: 
 * Entradas:   
 * Origens:   
           
**************************************************************************
*/

//Instancia Classe

$obj            =   new models_T0026();

?>
    <!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="?router=T0026/home" class="botao-padrao"><span class="ui-icon ui-icon-arrowthick-1-w"></span>Voltar    </a></li>
    </ul>
</div>

<!-- Divs INICIO Modal localOrigem e localDestino -->

<!-- Divs FIM Modal localOrigem e localDestino -->
<div class="dialog-despesa" title="+ Adicionar uma nova despesa!" style="display: none;">
    <div class="conteudo_16" style="width:auto;">

        <form action="" method="post" id="dialogForm">
        
            <div class="grid_6">
                <label style="display: none;color: red;border: 1px solid red;padding: 2px;">Preencha todos campos!</label>
            </div>

            <div class="clear10"></div>

            <div class="grid_2">
                <label>Data</label>
                <input type="text" class="data required" id="dialogData">
            </div>

            <div class="grid_1 prefix_3">
                <label>Km</label>
                <input type="text" id="dialogKm" disabled="disabled" class="required">
            </div>

            <div class="clear10"></div>

            <div class="grid_6">
                <label>Histórico/Detalhes</label>
                <textarea class="" id="dialogHistorico" maxlength="200" style="width:340px;height:100px;"></textarea>
            </div>

            <div class="clear10"></div>

            <div class="grid_4">
                <label>Origem</label>
                <select id="dialogLojaOrigem">
                    <option>Selecione...</option>
                </select>
            </div>

            <div class="grid_2">
                <label>Hora Origem</label>
                <select id="dialogHoraOrigem">                
                    <?php echo $obj->comboHora();?>
                </select>    
            </div>

            <div class="clear10"></div>

            <div class="grid_4">
                <label>Destino</label>
                <select id="dialogLojaDestino">
                    <option>Selecione...</option>
                </select>
            </div>

            <div class="grid_2">
                <label>Hora Destino</label>
                <select id="dialogHoraDestino">                
                    <?php echo $obj->comboHora();?>    
                </select>
            </div>                    
            
        </form>
        
    </div>    
</div>


<form action="" method="post">

    <div class="conteudo_16">
    
        <div id="tabs">
            <ul>
                <li class="ui-state-default"><a href="#tabs-1">Despesas com Quilometragem</a></li>
                <li class="ui-state-default"><a href="#tabs-2">Despesas Diversas</a></li>
            </ul>
            <!-- Inicio da div de despesas de quilometragem (tabs-1) -->
            <div id="tabs-1">

                <div class="grid_3">
                    <input type="button" class="botao-padrao botaoAddDespesa" value="Adicionar Despesa">
                </div>
                                                
                <div class="clear10"></div>

                <table id="tDespesa" class="tablesorter">
                    <thead>
                        <tr>
                            <th>Data            </th>
                            <th>Histórico/Origem</th>
                            <th>Origem          </th>
                            <th>Hora            </th>
                            <th>Destino         </th>
                            <th>Hora            </th>
                            <th>Km              </th>
                        </tr>
                    </thead>
                    <tbody id="dDados">
                    <tr>
                        <td>Teste</td>
                        <td>Teste</td>
                        <td>Teste</td>
                        <td>Teste</td>
                        <td>Teste</td>
                        <td>Teste</td>
                        <td>Teste</td>
                    </tr>
                </table>
                
            </div>          

            <div id="tabs-2">

                <div class="grid_3">
                    <input type="button" class="botao-padrao" value="Adicionar Despesa">
                </div>
                
                <div class="clear10"></div>

                <table id="tDespesaDiv" class="tablesorter">
                    <thead>
                        <tr>
                            <th>Data </th>
                            <th>Conta</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        <tr>
                            <td>Teste</td>
                            <td>Teste</td>
                            <td>Teste</td>
                        </tr>
                    </tbody>
                </table>
                
            </div>

        </div>        
        
    </div>
        
</form>




