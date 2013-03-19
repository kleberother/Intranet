<?php

//Classe para Usuarios
$obj            =   new models_T0069();
$DadosVariaveis =   $obj->retornaDadosVariaveis();   

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0069/home" class="active">Listar</a></li>
                <li><a href="?router=T0069/novo">Novo</a></li>
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
				<th width="10%">Template</th>
				<th width="17%">Corpo</th>
				<th width="17%">Tipo Origem</th>
				<th width="12%">Ações    </th>
			</tr>
		</thead>
		<tbody> <?php $i=1;?>
                        <?php foreach($DadosVariaveis as $campos=>$valores) {?>
			<tr class="dados">
                            <td><?php echo $obj->preencheZero("E", 3, $valores['CodigoTemplate']);?> - <?php echo $valores['NomeTemplate'];?>   </td>
				<td><?php echo $obj->preencheZero("E", 3, $valores['CodigoCorpo']);?> - <?php echo $valores['NomeCorpo'];?>     </td>
				<td><?php echo $valores['TpOrigemDadoVariavel'];?>                                                              </td>
                                <td class="acoes">
                                    <span class="lista_acoes">
                                    <ul>
                                        <li class="ui-state-default ui-corner-all" title="Alterar"  ><a href="?router=T0069/altera&cod=<?php echo ($valores['CodigoDadoVariavel']);?>"                                                      class="ui-icon ui-icon-pencil"    ></a></li>
                                        <li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0069','T0069/home','T058_tp_orig','T058_codigo',<?php echo ($valores['CodigoDadoVariavel']);?>,'',0,1)"  class="ui-icon ui-icon-closethick"></a></li>
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