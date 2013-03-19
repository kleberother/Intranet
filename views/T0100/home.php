<?php
//Chama classes

//Instancia Classe
$obj    = new models_T0100()    ;


$metas  = $obj->retornaMetas()  ;

$user   = $_SESSION['user']     ;

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0100/home" class="active">Listar</a></li>
                <li><a href="?router=T0100/novo">Novo</a></li>
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
				<th width="15%">Loja</th>
				<th width="8%">Mês/Ano</th>
				<th width="5%">QTD </th>
                                <th width="5%">Meta </th>
                                <th width="12%">Ações    </th>
			</tr>
		</thead>
		<tbody> <?php $i=1;?>
                        <?php foreach($metas as $campos=>$valores) {?>
			<tr class="dados">
				<td><?php echo $obj->preencheZero("E",3,$valores['CodigoLoja'])."-".$valores['NomeLoja'];?></td>
				<td><?php echo $valores['MesMeta'];?></td>
				<td><?php echo $valores['QtdeMeta'];?></td>
                                <td><?php echo money_format("%.2n",$valores['ValorMeta']);?></td>
				
                                <td class="acoes">
                                    <span class="lista_acoes">
                                    <ul>
                                        <li class="ui-state-default ui-corner-all" title="Alterar"  ><a href="?router=T0100/altera&codigoMeta=<?php echo ($valores['CodigoMeta']);?>"                                                  class="ui-icon ui-icon-pencil"    ></a></li>
                                        <li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0100','T0100/home','T100_meta_ge','T100_codigo',<?php echo ($valores['CodigoMeta']);?>,'','',1)"   class="ui-icon ui-icon-closethick"></a></li>
                                    </ul>
                                    </span>
                                </td>
			</tr>
                        <?php $i++; }?>
                 Caixa Dialogo Excluir 
                <div id="dialog-confirm" title="Mensagem!" style="display:none">
                    <p><span class="ui-icon ui-icon-alert" style="float:center; margin:0 7px 20px 0;"></span>Tem certeza que deseja excluir este item?</p>
                </div>
                </tbody>
	</table>
    </span>
</div>
