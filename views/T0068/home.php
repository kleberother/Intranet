<?php

//Classe para Usuarios
$obj        =   new models_T0068();
$Corpo      =   $obj->retornaCorpos();

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0068/home" class="active">Listar</a></li>
                <li><a href="?router=T0068/novo">Novo</a></li>
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
        <table class="form-inpu-tab" >
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
	<table class="ui-widget ui-widget-content tablesorter" id="tablesorter">
		<thead>
			<tr class="ui-widget-header ">
				<th width="12%">Template</th>
				<th>Nome</th>
				<th>Descrição</th>
				<th width="12%">Ações    </th>
			</tr>
		</thead>
		<tbody> <?php $i=1;?>
                        <?php foreach($Corpo as $campos=>$valores) {?>
			<tr class="dados">
				<td><?php echo $valores['CodigoTemplate'];?> - <?php echo $valores['NomeTemplate'];?></td>
				<td><?php echo $valores['NomeCorpo'];?></td>
				<td><?php echo $valores['DescricaoCorpo'];?></td>
                                <td class="acoes">
                                    <span class="lista_acoes">
                                    <ul>
                                        <li class="ui-state-default ui-corner-all" title="Alterar"  ><a href="?router=T0068/altera&cod=<?php echo ($valores['CodigoCorpo']);?>"                                                     class="ui-icon ui-icon-pencil"    ></a></li>
                                        <li class="ui-state-default ui-corner-all" title="Associar" ><a href="?router=T0068/associar&cod=<?php echo ($valores['CodigoCorpo']);?>&nom=<?php echo ($valores['NomeCorpo']);?>"         class="ui-icon ui-icon-plusthick" ></a></li>
                                        <li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0068','T0068/home','T033_corpo','T033_codigo',<?php echo ($valores['CodigoCorpo']);?>,'',0,1)"   class="ui-icon ui-icon-closethick"></a></li>
                                    </ul>
                                    </span>
                                </td>
			</tr>
                        <?php $i++; }?>
                <!-- Caixa Dialogo Excluir -->
                <div id="dialog-confirm" title="Mensagem!" style="display:none">
                    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja excluir este item?</p>
                </div>
                </tbody>
	</table>
    </span>
</div>