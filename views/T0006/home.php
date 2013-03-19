<?php
//Seleção de Extensões 
$objArquivos  = new models_T0006();
$Arquivos    = $objArquivos->selecionaArquivos();

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0009/home" class="active">Listar</a></li>
                <li><a href="?router=T0009/upload">Upload</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="conteudo">
    <span class="lista_itens">
	<table class="ui-widget ui-widget-content">
		<thead>
			<tr class="ui-widget-header ">
				<th>Código</th>
				<th>Nome        </th>
				<th>Descrição   </th>
                                <th>Dt. Upload  </th>
                                <th>Dono/Login  </th>
                                <th>Extensão    </th>
                                <th>Categoria   </th>
				<th>Ações       </th>
			</tr>
		</thead>
		<tbody>
                        <?php foreach($Arquivos as $campos=>$valores){?>
			<tr class="dados">
				<td><?php echo ($valores['COD']);?></td>
				<td><?php echo ($valores['NOM']);?></td>
				<td><?php echo ($valores['DES']);?></td>
                                <td><?php echo ($valores['DUP']);?></td>
                                <td><?php echo ($valores['LOG']);?></td>
                                <td><?php echo ($valores['N57']);?></td>
                                <td><?php echo ($valores['N56']);?></td>
                                <td class="acoes">
                                    <span class="lista_acoes">
                                    <ul>
                                        <li class="ui-state-default ui-corner-all" title="Alterar"  ><a href="?router=T0009/alterar&codigo=<?php echo ($valores['COD']);?>"  class="ui-icon ui-icon-pencil"              ></a></li>
                                        <li class="ui-state-default ui-corner-all" title="Excluir" ><a href="TESTE.PHP"                                                               class="ui-icon ui-icon-closethick"          ></a></li>
                                    </ul>
                                    </span>
                                </td>
			</tr>
                        <?php }?>
		</tbody>
	</table>
    </span>
</div>