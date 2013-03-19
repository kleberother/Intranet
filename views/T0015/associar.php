<?php 
//Pega parametros
$cod = $_REQUEST['cod'];
$codpro = $_REQUEST['codpro'];

//Classe para ***
$objGrpWF2 = new models_T0014();
$GrpWF2    = $objGrpWF2->selecionaGrpWork2($cod);


//Classe para **
$objUGWF = new models_T0014();
$UGWF    = $objUGWF->selecionaUserGrpWork($cod, $codpro);

$user = $_SESSION['user'];

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0014/home">Listar</a></li>
                <li><a href="?router=T0014/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="conteudo">
    <span class="lista_itens">
        <?php foreach($GrpWF2 as $campos=>$valores){?>
        <span class="form-titulo">
            <p><?php echo ($valores['N59']);?>/<?php echo ($valores['N61']);?></p>
        </span>
        <?php }?>
	<table class="ui-widget ui-widget-content">
		<thead>
			<tr class="ui-widget-header ">
				<th>Código   </th>
				<th>Login    </th>
				<th>Ações    </th>
			</tr>
		</thead>
		<tbody>
                        <?php 
                        if (!is_null($UGWF)){
                            foreach($UGWF as $campos=>$valores){
                        ?>
			<tr>
                            <td class="codigo"><?php echo ($valores['L04']);?></td>
                            <td>               <?php echo ($valores['N04']);?></td>
                            <td class="acoes">
                                <span class="lista_acoes">
                                <ul>
                                    <li class="ui-state-default ui-corner-all" title="Excluir" ><a href="#" class="ui-icon ui-icon-closethick"></a></li>
                                </ul>
                                </span>
                            </td>
			</tr>
                        <?php  }} else { ?>
                        <tr>
                            <td colspan="3">Não há usuarios associados a esse grupo!</td>
                        </tr>
                       <?php } ?>
		</tbody>
	</table>
    </span>
</div>
<div id="formulario">
    <span class="form-titulo">
        <p>Associar um usuário a esse grupo:</p>
    </span>
    <span class="form-input">
    <form action="#">
        <label class="label">Login*</label>
        <input type="text" name="T004_login" id="nome" class="form-input-text" />
        <div class="form-inpu-botoes">
            <input type="submit" value="Enviar" />
        </div>
    </form>
    </span>
</div>