<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 03/10/2011 por Jorge Nova                              
 * Descrição: Arquivo contem a lista de todos os artigos públicados
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/

// Objeto para execução de querys
$obj = new models_T0017();

$Artigos = $obj->retornaArtigos();

// Retorna os artigos criados

$user = $_SESSION['user'];

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0017/home" class="active">Listar</a></li>
                <li><a href="?router=T0017/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="conteudo">
    <span class="lista_itens">
	<table class="ui-widget ui-widget-content">
		<thead>
                    <tr class="ui-widget-header ">
                        <th>Texto              </th>
                        <th>Tempo de Publicação</th>
                        <th width="12%">Ações              </th>
                    </tr>
		</thead>
		<tbody>
                    <?php foreach($Artigos as $campos=>$valores){
                    ?>
                    <tr class="dados">
                        <td><?php echo $obj->preencheZero("E", 3, $valores['Codigo']);?> - <?php echo $valores['Titulo'];?></td>
                        <td><?php echo $valores['DataInicial']."-".$valores['DataFinal'];?></td>
                        <td class="acoes">
                            <span class="lista_acoes">
                            <ul>
                                <li class="ui-state-default ui-corner-all" title="Detalhes" ><a href="?router=T0017/detalhe&cod=<?php echo ($valores['Codigo']);?>"  class="ui-icon ui-icon-search" id="" ></a></li>
                                <li class="ui-state-default ui-corner-all" title="Alterar"  ><a href="?router=T0017/altera&cod=<?php echo ($valores['Codigo']);?>"   class="ui-icon ui-icon-pencil" id="" ></a></li>
                                <li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0017','T0017/home','T046_artigos','T046_codigo',<?php echo ($valores['Codigo']);?>)"   class="ui-icon ui-icon-closethick"></a></li>                            </ul>
                            </span>
                        </td>
                    </tr>
                    <?php }?>
                <!-- Caixa Dialogo Excluir -->
                <div id="dialog-confirm" title="Mensagem!" style="display:none">
                    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja excluir este item?</p>
                </div>
		</tbody>
	</table>
    </span>
</div>