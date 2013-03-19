<?php
//Chama classes

//Classe para Usuarios
$objUsuario = new models_T0010();
$Usuario    = $objUsuario->listarUsuarios();

$user = $_SESSION['user'];

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0010/home" class="active">Listar</a></li>
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
                            <th width="8%">Matricula</th>
                            <th>Nome     </th>
                            <th>Login    </th>
                            <th>Loja     </th>
                            <th>Permissão de Upload</th>
                            <th width="9%">Ações    </th>
			</tr>
		</thead>
		<tbody>
                        <?php foreach($Usuario as $campos=>$valores){?>
			<tr class="dados">
				<td><?php echo ($valores['Matricula']);?></td>
				<td><?php echo ($valores['Nome']);?></td>
				<td><?php echo ($valores['Login']);?></td>
				<td>
                                    <?php
                                        if($valores['CodigoLoja'] == NULL)
                                            echo "<span style='color:red;'>NÃO HÁ LOJA ASSOCIADA</span>";
                                        else                                                
                                            echo ($objUsuario->preencheZero ("E", 3, $valores['CodigoLoja']))." - ".($valores['NomeLoja']);
                                    ?>
                                </td>
                                <td>
                                   <?php
                                        if($valores['Permissao'] == NULL)
                                            echo "<p class='centerp'><span class='ui-icon ui-icon-check'></span></p>";
                                        else
                                            echo "<p class='centerp'><span class='ui-icon ui-icon-close'></span></p>";
                                   ?>
                                </td>
                                <td class="acoes">
                                    <span class="lista_acoes">
                                    <ul>
                                        <li class="ui-state-default ui-corner-all" title="Detalhes"><a href="?router=T0010/detalhe&login=<?php echo ($valores['LOGI']);?>" class="ui-icon ui-icon-search"              ></a></li>
                                        <li class="ui-state-default ui-corner-all" title="Editar"  ><a href="?router=T0010/altera&login=<?php echo ($valores['LOGI']);?>"  class="ui-icon ui-icon-pencil"              ></a></li>
                                    </ul>
                                    </span>
                                </td>
			</tr>
                        <?php }?>
		</tbody>
	</table>
    </span>
</div>