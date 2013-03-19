<?php
//Pega parametros
$cod = $_REQUEST['cod'];
$nom = $_REQUEST['nom'];
//Classe para Usuarios
$objPerfil =    new models_T0005();
$Usuarios  =    $objPerfil->selecionaUsuarios($cod);
$Perfil    =    $objPerfil->selecionaPerfil($cod);
$Estrutura =    $objPerfil->selecionaEstrutura($cod);

$user = $_SESSION['user'];

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0005/home">Listar</a></li>
                <li><a href="?router=T0005/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="conteudo">
    <span class="lista_itens">
        <span class="form-titulo">
            <p>Perfil: <?php echo $cod." - ".$nom; ?></p>
        </span>
        <span class="form-titulo">
            <p>Usuários Associados a este Perfil:</p>
        </span>
        <table class="ui-widget ui-widget-content">
		<thead>
			<tr class="ui-widget-header ">
				<th>Login       </th>
				<th>Matricula   </th>
				<th>Nome        </th>
			</tr>
		</thead>
		<tbody>
                        <?php foreach($Usuarios as $campos=>$valores){?>
			<tr>
                                <td><?php echo ($valores['MAT']);?></td>
                                <td><?php echo ($valores['L04']);?></td>
                                <td><?php echo ($valores['N04']);?></td>
			</tr>
                        <?php }?>
		</tbody>
	</table>
        <span class="form-titulo">
            <p>Menus/Programas habilitados para este perfil:</p>
        </span>
        <table class="ui-widget ui-widget-content">
		<thead>
			<tr class="ui-widget-header ">
				<th>Código      </th>
				<th>Nome        </th>
				<th>Descrição   </th>
                                <th>Tipo        </th>
			</tr>
		</thead>
		<tbody>
                        <?php foreach($Usuarios as $campos=>$valores){?>
			<tr>
                                <td class="codigo"><?php echo ($valores['COD']);?></td>
                                <td><?php echo ($valores['NOM']);?></td>
                                <td><?php echo ($valores['DES']);?></td>
                                <td><?php echo ($valores['TIP']);?></td>
			</tr>
                        <?php }?>
		</tbody>
	</table>
    </span>
</div>
<div id="formulario">
    <span class="form-input">
    </span>
</div>