<?php
//Chama classes

//Classe para Usuarios
$objEst = new models_T0004();
$Est    = $objEst->listarEstrutura();

$user = $_SESSION['user'];

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0004/home" class="active">Listar</a></li>
                <li><a href="?router=T0004/novo">Novo</a></li>
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
				<th>Programas e Menus </th>
				<th>Descrição</th>
				<th width="5%">Pai      </th>
                                <th width="5%">Tipo     </th>
				<th width="12%">Ações    </th>
			</tr>
		</thead>
		<tbody> <?php $i=1;?>
                        <?php foreach($Est as $campos=>$valores) {?>
			<tr class="dados">
				<td><?php echo $valores['COD'];?> - <?php echo $valores['NOM'];?></td>
				<td><?php echo $valores['DES'];?></td>
				<td><?php echo $valores['PAI'];?></td>
				<td>
                                    <?php
                                        if ($valores['TIP'] == 0)
                                        {
                                            echo "Privado";
                                        }
                                        else
                                        {
                                            echo "Público";
                                        }
                                    ;?>
                                </td>
                                <td class="acoes">
                                    <span class="lista_acoes">
                                    <ul>
                                        <li class="ui-state-default ui-corner-all" title="Alterar"  ><a href="?router=T0004/altera&cod=<?php echo ($valores['COD']);?>"                                                  class="ui-icon ui-icon-pencil"    ></a></li>
                                        <li class="ui-state-default ui-corner-all" title="Associar" ><a href="?router=T0004/associar&cod=<?php echo ($valores['COD']);?>&nom=<?php echo ($valores['NOM']);?>"                                                class="ui-icon ui-icon-plusthick" ></a></li>
                                        <li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0004','T0004/home','T007_estrutura','T007_codigo',<?php echo ($valores['COD']);?>,'',0,1)"   class="ui-icon ui-icon-closethick"></a></li>
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