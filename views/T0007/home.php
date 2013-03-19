<?php
//Seleção de Extensões 
$objExtensoes  = new models_T0007();
$Extensoes    = $objExtensoes->selecionaExtensoes();

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0007/home" class="active">Listar</a></li>
                <li><a href="?router=T0007/novo">Novo</a></li>
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
				<th>Extensões     </th>
				<th>Descrição</th>
				<th width="9%">Ações    </th>
			</tr>
		</thead>
		<tbody>
                        <?php foreach($Extensoes as $campos=>$valores){?>
			<tr class="dados">
				<td><?php echo ($valores['COD']);?> - <?php echo ($valores['NOM']);?></td>
				<td><?php echo ($valores['DES']);?></td>
                                <td class="acoes">
                                    <span class="lista_acoes">
                                    <ul>
                                        <li class="ui-state-default ui-corner-all" title="Alterar"  ><a href="?router=T0007/altera&codigo=<?php echo ($valores['COD']);?>"  class="ui-icon ui-icon-pencil"              ></a></li>
                                        <li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0007','T0007/home','T057_extensao','T057_codigo',<?php echo ($valores['COD']);?>)"   class="ui-icon ui-icon-closethick"></a></li>
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