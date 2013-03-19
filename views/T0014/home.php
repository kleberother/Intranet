<?php
//Classe para **
$objGrpWF = new models_T0014();
$GrpWF    = $objGrpWF->selecionaGrpWork();
?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0014/home" class="active">Listar</a></li>
                <li><a href="?router=T0014/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-2">Filtro Dinâmico</a></li>
    </ul>
    <div id="tabs-2">
        <form action="#">
        <table class="form-inpu-tab">
            <thead>
                <tr>
                    <th width="155px"><label>Filtro</label></th>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="search" value="" id="id_search" />
                    </td>
                    <td><span class="loading">Carregando...</span></td>
                </tr>
            </thead>
        </table>
        </form>
    </div>
</div>
<div id="conteudo">
    <span class="lista_itens">
	<table class="ui-widget ui-widget-content">
		<thead>
			<tr class="ui-widget-header ">
				<th width="10%">Processo         </th>
				<th width="20%">Grupo de Workflow</th>
				<th>Descrição        </th>
				<th>Owner            </th>
				<th width="12%">Ações</th>
			</tr>
		</thead>
		<tbody>
                        <?php foreach($GrpWF as $campos=>$valores){?>
			<tr class="dados">
				<td><?php echo ($valores['C61'])." - ".($valores['PRO']);?></td>
				<td><?php echo ($valores['C59'])." - ".($valores['NOM']);?></td>
				<td><?php echo ($valores['DES']);?></td>
				<td><?php echo ($valores['LOG']);?></td>
                                <td class="acoes">
                                    <span class="lista_acoes">
                                    <ul>
                                        <li class="ui-state-default ui-corner-all" title="Alterar"  ><a href="?router=T0014/altera&cod=<?php echo ($valores['C59']);?>"                                                     class="ui-icon ui-icon-pencil"               id=""          ></a></li>
                                        <li class="ui-state-default ui-corner-all" title="Associar" ><a href="?router=T0014/associar&cod=<?php echo ($valores['C59']);?>&codpro=<?php echo ($valores['C61']);?>"  class="ui-icon ui-icon-plusthick"            id=""          ></a></li>
                                        <li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0014','T0014/home','T059_grupo_workflow','T059_codigo',<?php echo ($valores['C59']);?>)"          class="ui-icon ui-icon-closethick"                          ></a></li>
                                    </ul>
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