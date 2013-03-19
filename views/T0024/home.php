<?php
//Chama classes

//
$objT002 = new models_T0024();
$T002    = $objT002->listaT002();


$user = $_SESSION['user'];

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0024/home" class="active">Listar</a></li>
                <li><a href="?router=T0024/novo">Novo</a></li>
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
                        <th width="20%">Data Type    </th>
                        <th>Descrição    </th>
                        <th width="12%">Ações    </th>
                    </tr>
		</thead>
		<tbody>
                    <?php foreach($T002 as $campos=>$valores){?>
                    <tr>
                        <td><?php echo ($valores['P0024_T002_COD']);?> - <?php echo ($valores['P0024_T002_VAL']);?></td>
                        <td><?php echo ($valores['P0024_T002_DES']);?></td>
                        <td class="acoes">
                            <span class="lista_acoes">
                            <ul>
                                <li class="ui-state-default ui-corner-all" title="Detalhes" ><a href="?router=T0024/detalhe&cod=<?php echo ($valores['P0024_T002_COD']);?>"  class="ui-icon ui-icon-search" id="" ></a></li>
                                <li class="ui-state-default ui-corner-all" title="Alterar"  ><a href="?router=T0024/altera&cod=<?php echo ($valores['P0024_T002_COD']);?>"   class="ui-icon ui-icon-pencil" id="" ></a></li>
                                <li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0024','T0024/home','T002_datatype','T002_codigo',<?php echo ($valores['P0024_T002_COD']);?>)"   class="ui-icon ui-icon-closethick"></a></li>
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