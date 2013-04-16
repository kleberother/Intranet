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

$parametro      =   $obj->retornaParametroKm();
$contas         =   $obj->retornaContas();

?>
    <!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="?router=T0026/home" class="botao-padrao"><span class="ui-icon ui-icon-arrowthick-1-w"></span>Voltar    </a></li>
    </ul>
</div>

<div class="dialog-despesa" title="+ Adicionar uma nova despesa!" style="display: none;">
    <div class="conteudo_16" style="width:auto;">

        <form action="" method="post" id="dialogForm">
        
            <div class="grid_6">
                <label style="display: none;color: red;border: 1px solid red;padding: 2px;">Preencha todos campos!</label>
            </div>

            <div class="clear10"></div>

            <div class="grid_2">
                <label>Data *</label>
                <input type="text" class="data validate[required] required" id="dialogData">
            </div>

            <div class="clear10"></div>

            <div class="grid_6">
                <label>Histórico/Detalhes *</label>
                <textarea class="required" id="dialogHistorico" maxlength="200" style="width:340px;height:100px;"></textarea>
            </div>

            <div class="clear10"></div>

            <div class="grid_4">
                <label>Origem *</label>
                <select id="dialogLojaOrigem" class="required">
                </select>
            </div>

            <div class="grid_2">
                <label>Hora Origem *</label>
                <select id="dialogHoraOrigem" class="required">                
                    <?php echo $obj->comboHora();?>
                </select>    
            </div>
            
            <div class="clear10"></div>
            
            <div class="grid_6" style="display:none" id="externoOrigem">
                <label>Externo Origem *</label>
                <input type="text" maxlength="200" id="txtExternoOrigem"/>              
            </div>

            <div class="clear10"></div>

            <div class="grid_4">
                <label>Destino *</label>
                <select id="dialogLojaDestino" class="required">
                </select>
            </div>

            <div class="grid_2">
                <label>Hora Destino *</label>
                <select id="dialogHoraDestino" class="required">                
                    <?php echo $obj->comboHora();?>    
                </select>
            </div>
            
            <div class="clear10"></div>
            
            <div class="grid_4" style="display:none" id="externoDestino">
                <label>Externo Destino *</label>
                <input type="text" maxlength="200" id="txtExternoDestino"/>
            </div>            
            
            <div class="grid_1">
                <label>Km *</label>
                <input type="text" id="dialogKm" disabled="disabled" class="required"/>
            </div>            
            
        </form>
        
    </div>    
</div>

<div class="dialog-despesa-diversas" title="+ Adicionar uma nova despesa!" style="display: none;">
    <div class="conteudo_16" style="width:auto;">

        <form action="" method="post" id="dialogFormDiversos">
        
            <div class="grid_6">
                <label style="display: none;color: red;border: 1px solid red;padding: 2px;">Preencha todos campos!</label>
            </div>

            <div class="clear10"></div>

            <div class="grid_2">
                <label>Data *</label>
                <input type="text" class="data required" id="dialogDataDiversos">
            </div>

            <div class="clear10"></div>

            <div class="grid_6">
                <label>Conta *</label>
                <select id="dialogContaDiversos" class="required">
                    <?php foreach($contas as $campos => $valores){?>
                    <option value="<?php echo $valores['ContaCRF'];?>"><?php echo $obj->preencheZero("E", 3, $valores['ContaCRF'])."-".$valores['ContaNome'];?></option>
                    <?php }?>
                </select>
            </div>

            <div class="clear10"></div>

            <div class="grid_2">
                <label>Valor *</label>
                <input type="text" id="dialogValorDiversos" class="valor required"/>
            </div>          
            
        </form>
        
    </div>    
</div>


<form action="" method="post">

    <div class="conteudo_16">
        
        <div class="clear10"></div>
        
        <div class="grid_3" style="display:none;">
            <input type="hidden"  id="codigoDespesa"/>
        </div>        
        
        <div class="grid_3">
            <p>CPF*</p>
            <input type="text"  class="cpf validate[required]" id="campoCpf"/>
        </div>        
                
        <div class="grid_6">
            <p>Nome</p>
            <input type="text" disabled="disabled" id="nomeColaborador"/>
        </div>        
        
        <div class="grid_2" id="parametro" style="display:none;">
            <p>Valor Km</p>
            <input type="text"      class="valor" disabled="disabled"                  value="<?php echo $obj->formataMoeda($parametro);?>"/>
            <input type="hidden"    class="valor" disabled="disabled" id="parametroKm" value="<?php echo $parametro;?>"/>
        </div>        
        
    </div>
        
    <div id="abasDespesa" class="conteudo_16" style="display:none">
            
        <div id="tabs" style="width: auto;">
            <ul>
                <li class="ui-state-default"><a href="#tabs-1">Despesas com Quilometragem</a></li>
                <li class="ui-state-default"><a href="#tabs-2">Despesas Diversas</a></li>
            </ul>
            <!-- Inicio da div de despesas de quilometragem (tabs-1) -->
            <div id="tabs-1">
                
                <div class="conteudo_12">

                    <div class="grid_3">
                        <input type="button" class="botao-padrao botaoAddDespesa" value="Adicionar Despesa">
                    </div>

                    <div class="clear10"></div>

                    <table id="tDespesa" class="tablesorter">
                        <thead>
                            <tr>
                                <th width="7%">Data         </th>
                                <th>Histórico               </th>
                                <th width="15%">Origem      </th>
                                <th width="4%">Hora         </th>
                                <th width="15%">Destino     </th>
                                <th width="4%">Hora         </th>
                                <th width="4%">Km           </th>
                                <th width="4%">Ações        </th>
                            </tr>
                        </thead>
                        <tbody id="dDados">                        
                        <tr id="linhaInfo">
                            <td colspan="7" align="center">Clique em adicionar despesa para uma nova despesa.</td>
                        </tr>
                    </table>

                    <div class="clear10"></div>  

                    <div class="grid_3 prefix_14">
                        <p>Total Despesas Km</p>
                        <input type="text" class="valor" id="totalDespesaKm" disabled="disabled"/>
                    </div> 
                    
                    <div class="clear10"></div>  
                
                </div>
                
            </div>          

            <div id="tabs-2">
                
                <div class="conteudo_12">

                    <div class="grid_3">
                        <input type="button" class="botao-padrao botaoAddDespesaDiversas" value="Adicionar Despesa">
                    </div>

                    <div class="clear10"></div>

                    <table id="tDespesaDiv" class="tablesorter">
                        <thead>
                            <tr>
                                <th>Data </th>
                                <th>Conta</th>
                                <th>Valor</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="dDadosDiversos">                        
                            <tr id="linhaInfoDiversos">
                                <td colspan="3" align="center">Clique em adicionar despesa para uma nova despesa.</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="clear10"></div>  

                    <div class="grid_3 prefix_14">
                        <p>Total Despesas Diversas</p>
                            <input type="text" id="totalDespesaDiversas" disabled="disabled"/>
                    </div>

                    <div class="clear10"></div>  
                
                </div>
                
            </div>

        </div>        
        
    </div>
    
    <div class="conteudo_16" style="display:none" id="botaoIncluir">
    
        <div class="grid_3 prefix_14">
            <p>Total Geral</p>
            <input type="text" id="totalGeral" disabled="disabled"/>
        </div>
        
        <div class="clear10"></div>
    
        <div class="grid_3">
            <input type="button" class="botao-padrao botaoInserir" value="Incluir">
        </div>
    
    </div>
        
</form>




