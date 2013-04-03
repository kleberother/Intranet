<?php 

//Instancia Classe
$obj    =   new models_T0117();  
 
if (!empty($_POST))    
{
    $titulo         =   $_POST['T113_titulo'];
    $descricao      =   $_POST['T113_descricao'];
    $solicitante    =   $_POST['T004_solicitante'];   
    $rm             =   $_POST['T113_codigo'];
        
    $dados          =   $obj->retornaRM($titulo, $descricao, $solicitante, $rm);
}else
echo "";    

//$dados          =   $obj->retornaRM();

?>
<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">        
        <li><a href="#"                     class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-filter"  ></span>Filtros </a></li>
        <li><a href="?router=T0117/novo"    class="             botao-padrao"><span class="ui-icon ui-icon-plus"    ></span>Novo    </a></li>
    </ul>
</div>

<!-- Divs com filtros -->
<div class="div-primaria div-filtro">
    <form action="" method="post">
        
        <div class="conteudo_16">
            
            <div class="grid_3">
                <label class="label">Título</label>
                <input  type="text" name="T113_titulo" value="<?php echo $titulo;?>"/>
            </div>
            
            <div class="grid_3">
                <label class="label">Descrição</label>
                <input  type="text" name="T113_descricao" value="<?php echo $descricao;?>"/>                
            </div>
            
            <div class="grid_3">
                <label class="label">Solicitante</label>
                <input  type="text" name="T004_solicitante" value="<?php echo $solicitante;?>"/>                
            </div>
            
            <div class="grid_2">
                <label class="label">Número RM</label>
                <input  type="text" name="T113_codigo" value="<?php echo $rm;?>"/>                
            </div>
            
            <div class="grid_2">
                <input type="submit" value="Filtrar" class="botao-padrao" />                          
            </div>
            
            <div class="clear10"></div>
            
            <table class="tablesorter tDados">
                <thead>
                    <tr class="ui-widget-header ">
                        <th>RM </th>
                        <th>Data Hora   </th>
                        <th width="40%">Título      </th>
                        <th>Solicitante </th>
                        <th>Status      </th>
                        <th>Ações       </th>
                    </tr>
                </thead>
                <tbody class="campos">
                    <?php foreach($dados    as  $campos =>  $valores){?>
                    <tr class="linha_<?php echo $valores["CodigoRM"];?>">
                        <td><label class="rmCmp"><?php echo sprintf("%06s",$valores['CodigoRM']);?></label></td>
                        <td><?php echo $valores['DataRM'];?></td>
                        <td><?php echo $valores['TituloRM'];?></td>
                        <td><?php echo $valores['SolicitanteNome']." - ".$valores['SolicitanteLogin'];?></td>
                        <td><?php $obj->nomeStatus($valores['StatusRM']);?></td>
                        <td class="acoes">
                            <span class="lista_acoes">
                                <ul>
                                    <li class="ui-state-default ui-corner-all" title="Alterar">
                                        <a href="?router=T0117/alterar&codRM=<?php echo $valores['CodigoRM'];?>" class="ui-icon ui-icon-pencil"></a> 
                                    </li>
                                    <li class="ui-state-default ui-corner-all" title="Visualizar">
                                        <a href="?router=T0117/consultar&codRM=<?php echo $valores['CodigoRM'];?>" class="ui-icon ui-icon-search"></a> 
                                    </li>
                                </ul>
                                <ul>
                                    <li class="ui-state-default ui-corner-all" title="Excluir">
                                        <a href="#" onclick="excluirLinha(<?php echo $valores['CodigoRM'];?>)" class="ui-icon ui-icon-closethick"></a> 
                                    </li>
                                </ul>
                           </span>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>            
            
            
        </div>
        
    </form>        
</div>