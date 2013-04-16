<?php
// teste ORAAS141
//Instancia Classe
$conn      =   "emporium";
$objEMP    =   new models_T0119($conn);

$RetornoLotes  = $objEMP->ConsultaLotesLoja(1);



/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
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
                        