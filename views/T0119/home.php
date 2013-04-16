<?php
// teste ORAAS141
//Instancia Classe
$conn       =   "emporium";
$objEMP     =   new models_T0119($conn);
$obj        =   new models_T0119();

if(!empty($_POST))
{   
    
    $filtroLoja             =   $_REQUEST['FiltroLoja']             ;
    $filtroDtInicio         =   $_REQUEST['FiltroDataInicio']       ;
    $filtroDtFim            =   $_REQUEST['FiltroDataFim']          ;
    $filtroStatusConsumo    =   $_REQUEST['FiltroStatusConsumo']    ;
    $filtroStatusIntegracao =   $_REQUEST['FiltroStatusIntegracao'] ;
    $filtroStatusAprovacao  =   $_REQUEST['FiltroStatusAprovacao']  ;
    $filtroRegistros        =   $_REQUEST['FiltroRegistros']        ;
        
    $RetornoLotes   =   $objEMP->ConsultaLotesLoja($filtroLoja, $filtroDtInicio, $filtroDtFim, $filtroStatusConsumo, $filtroStatusIntegracao, $filtroStatusAprovacao, $filtroRegistros);
}

$SelectBoxLoja              =   $obj->retornaLojasSelectBox();
$SelectStatusIntegracao     =   $objEMP->retornaStatusIntegracao();
$SelectStatusConsumo        =   $objEMP->retornaStatusConsumo();
$SelectStatusAprovacao      =   $objEMP->retornaStatusAprovacao();

?>
<div id="dialog-aprovar" style="display:none;">
    
</div>
<div id="dialog-detalhes" style="display:none;">
    
</div>
<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="#"                     class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-filter"  ></span>Filtros </a></li>
    </ul>
</div>

<!-- Divs com filtros oculta -->
<div class="conteudo_16  div-filtro">
    
    <form action="" method="post" class="div-filtro-visivel">
        <!--<input type="hidden" name="router" value="T0119/home" />-->
        
        <div class="grid_4">       
            <label class="label">Loja</label>
            <select name="FiltroLoja">
                <option value="">Todas</option>
                <?php foreach($SelectBoxLoja as $campos=>$valores){?>
                <option value="<?php echo substr($valores['LojaCodigo'], 0, -1);?>" <?php echo substr($valores['LojaCodigo'], 0, -1)==$filtroLoja?"selected":"";?>><?php echo $obj->preencheZero("E",3,$valores['LojaCodigo'])."-".$valores['LojaNome'];?></option>
                <?php }?>
            </select>                                       
        </div>
        
        <div class="grid_2">
            <label class="label">Data Início</label>
            <input type="text" name="FiltroDataInicio"  class="data"    value="<?php echo $_REQUEST['FiltroDataInicio'];?>"/>               
        </div>
        
        <div class="grid_2">
            <label class="label">Data Fim</label>
            <input type="text" name="FiltroDataFim"     class="data"    value="<?php echo $_REQUEST['FiltroDataFim'];?>"/>               
        </div>
        
        <div class="grid_4">
        <label class="label">Status Consumo</label>
            <select name="FiltroStatusConsumo">
                <option value="">Todos</option>
                <?php foreach($SelectStatusConsumo as $campos=>$valores){?>
                <option value="<?php echo $valores['Codigo'];?>" <?php echo $valores['Codigo']==$filtroStatusConsumo?"selected":"";?>><?php echo $obj->preencheZero("E",3,$valores['Codigo'])."-".$valores['Descricao'];?></option>
                <?php }?>
            </select>            
        </div>
        
        <div class="grid_4">
        <label class="label">Status Integração</label>
            <select name="FiltroStatusIntegracao">
                <option value="">Todos</option>
                <?php foreach($SelectStatusIntegracao as $campos=>$valores){?>
                <option value="<?php echo $valores['Codigo'];?>" <?php echo $valores['Codigo']==$filtroStatusIntegracao?"selected":"";?>><?php echo $obj->preencheZero("E",3,$valores['Codigo'])."-".$valores['Descricao'];?></option>
                <?php }?>
            </select>            
        </div>
        
        <div class="grid_4">
        <label class="label">Status Aprovação</label>
            <select name="FiltroStatusAprovacao">
                <option value="">Todos</option>
                <?php foreach($SelectStatusAprovacao as $campos=>$valores){?>
                <option value="<?php echo $valores['Codigo'];?>" <?php echo $valores['Codigo']==$filtroStatusAprovacao?"selected":"";?>><?php echo $obj->preencheZero("E",3,$valores['Codigo'])."-".$valores['Descricao'];?></option>
                <?php }?>
            </select>            
        </div>
                
        <div class="grid_2">
        <label class="label">Qtde Registros</label>
            <select name="FiltroRegistros">
                <option value="50"  <?php echo $filtroRegistros==50 ?"selected":""?>>50     </option>
                <option value="100" <?php echo $filtroRegistros==100?"selected":""?>>100    </option>
                <option value=""    <?php echo $filtroRegistros=="" ?"selected":""?>>Todos  </option>
            </select>            
        </div>

        <div class="grid_1">
            <input type="submit" class="botao-padrao" value="Filtrar">
        </div>
        
        <div class="clear5"></div>
                
    </form>
    
</div>

<div class="conteudo_16">    
                
    <table id="tPrincipal" class="tablesorter">
        <thead>
            <tr>
                <!--<th><input type="checkbox" value="1" class="chkSelecionaTodos" <?php echo $statusDespesa!=1?"disabled":""?>/></th>-->
                <th>Lote</th>
                <th>Loja</th>
                <th>Valor</th>
                <th>Valor</th>
                <th>Ações</th>
                
<!--                <th>Data</th>
                <th>Última Etapa</th>
                <th>Valor</th>
                <th>Arquivos</th>
                <th>Ações</th>-->
            </tr>
        </thead>
        <tbody>
        <?php   foreach($RetornoLotes as $campos=>$valores){?>            
            <tr>
                <!--<td><?php echo "DespesaCodigo:".$valores['DespesaCodigo'].";"."EtapaCodigo:".$valores['CodigoEtapa'];?>" class="chkItem" <?php echo $statusDespesa!=1?"disabled":""?></td>-->
                <td class="txtLote"><?php echo $valores['lote_numero']; ?></td>
                <td class="txtLoja"><?php echo $valores['store_key']; ?></td>
                <td ><?php echo $objEMP->RetornaStringTipo($valores['tipo_codigo']); ?></td>
                <td><?php echo $valores['amount'];?></td>
                <td>                                    
                    <ul class="lista-de-acoes">                                        
                        <li><a href="#" title="Detalhes" class="Detalhes">    <span class='ui-icon ui-icon-search'> </span></a></li>                                    
                        <li><a href="#" title="Aprovar"  class="Aprovar" >    <span class='ui-icon ui-icon-check'>  </span></a></li>
                    </ul>
                </td>
            </tr>
        <?php }?>
        </tbody>
        
    </table>
</div>
                        