<?php
//Pega parametros
$cod = $_REQUEST['cod'];
$codpro = $_REQUEST['codpro'];
$tabela = "T004_T059";

//Classe para ***
$objT059 = new models_T0014();
$GrpWF2  = $objT059->selecionaGrpWork2($cod);

$UGWF    = $objT059->selecionaUserGrpWork($cod, $codpro);

//Verifica se NULL para executar a Inserção
if(!is_null($_POST['T004_login']))
{
    $objT059->insereT004_T059($tabela, $_POST);
    header('location:?router=T0014/associar&cod='.$cod."&codpro=".$codpro);
}

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
            <p>Processo: <?php echo ($valores['N61']);?> - Grupo: <?php echo ($valores['N59']);?></p>
        </span>
        <?php }?>
	<table class="ui-widget ui-widget-content">
		<thead>
			<tr class="ui-widget-header ">
				<th>Login    </th>
				<th>Nome     </th>
				<th>Ações    </th>
			</tr>
		</thead>
		<tbody> <?php $i==0;?>
                        <?php foreach($UGWF as $campos=>$valores){ ?>
                        <?php $i++;?>
			<tr>
                            <td class="codigo"><?php echo ($valores['L04']);?></td>
                            <td>               <?php echo ($valores['N04']);?></td>
                            <td class="acoes">
                                <span class="lista_acoes">
                                <ul>
                                    <li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0014','T0014/associar&cod=<?php echo $cod;?>&codpro=<?php echo $codpro;?>','T004_T059','T004_login','<?php echo ($valores['L04']);?>')" class="ui-icon ui-icon-closethick"></a></li>
                                </ul>
                                </span>
                            </td>
			</tr>
                        <?php } if($i==0) { ?>
                        <tr>
                            <td colspan="3">Não há usuarios associados a esse grupo!</td>
                        </tr>
                       <?php } ?>
                <!-- Caixa Dialogo Excluir -->
                <div id="dialog-confirm" title="Mensagem!" style="display:none">
                    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja excluir este item?</p>
                </div>
		</tbody>
	</table>
    </span>
</div>
<div id="formulario">
    <span class="form-titulo">
        <p>Associar um usuário a esse grupo:</p>
    </span>
    <span class="form-input">
    <form action="" method="post" id="formCad">
        <input type="hidden" name="T059_codigo" value="<?php echo $cod; ?>"    READONLY />
        <input type="hidden" name="T061_codigo" value="<?php echo $codpro; ?>" READONLY />
        <label class="label">Login*</label>
        <input type="text" name="T004_login" id="nome" class="validate[required] form-input-text" />
        <div class="form-inpu-botoes">
            <input type="submit" value="Associar" />
        </div>
    </form>
    </span>
</div>