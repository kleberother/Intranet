<?php
//Chama classes

$user      = $_SESSION['user'];
$obj       = new models_T0022();
$Pesquisa  = $obj->retornaPesquisas();

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0022/home" class="active">Listar</a></li>
                <li><a href="?router=T0022/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="conteudo">
    <span class="lista_itens">
	<table class="ui-widget ui-widget-content">
		<thead>
			<tr class="ui-widget-header ">
                                <th>Código          </th>
                                <th>Data da Pesquisa</th>
				<th>Loja Pesquisada</th>
				<th>Autor da Pesquisa</th>
				<th width="15%">Ações</th>
			</tr>
		</thead>
		<tbody>
                        <?php foreach($Pesquisa as $campos=>$valores){?>
			<tr class="dados">
				<td><?php echo ($valores['Codigo']);?></td>
                                <td><?php echo ($valores['DataPesquisa']);?></td>
				<td><?php echo ($valores['NomePosto']);?></td>
				<td><?php echo ($valores['Usuario']);?></td>
                                <td class="acoes">
                                    <span class="lista_acoes">
                                    <ul>
                                        <li class="ui-state-default ui-corner-all" title="Detalhes" ><a href="?router=T0022/detalhe&cod=<?php echo ($valores['Codigo']);?>"  class="ui-icon ui-icon-search"              ></a></li>
                                        <!--<li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0005','T0005/home','T009_perfil','T009_codigo',<?php// echo ($valores['Codigo']);?>)"   class="ui-icon ui-icon-closethick"></a></li>-->
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