<?php
//Parametros e Tabela
$cod            =   $_REQUEST['cod'];
$nom            =   $_REQUEST['nom'];
$tabela         =   "T007_T009";

//Lista Dados
$objAssociados  =   new models_T0004();
$Associados     =   $objAssociados->listarAssociados($cod);
$Perfis         =   $objAssociados->listarPerfis($cod);

//Verifica se NULL para executar a Inserção
if(!is_null($_POST['T007_codigo']))
{
    unset ($_POST['nom']);
    $objAssociados->insereEstrutura($tabela, $_POST);
    header('location:?router=T0004/associar&cod='.$cod.'&nom='.$nom);
}
?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0004/home">Listar</a></li>
                <li><a href="?router=T0004/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="conteudo">
    <span class="lista_itens">
    <span class="form-titulo">
        <p><?php echo "Programa: ".$cod." - ".$nom?></p>
    </span>
	<table class="ui-widget ui-widget-content">
		<thead>
			<tr class="ui-widget-header ">
                            <th width="95%">Perfil   </th>
                            <th>            Ações    </th>
			</tr>
		</thead>
		<tbody>
                        <?php $i=0;?>
                        <?php foreach($Associados as $campos=>$valores){?>
                        <?php $i++;?>
			<tr>
                            <td><?php echo ($valores['C09'])." - ".($valores['N09']);?></td>
                            <td class="acoes">
                                <span class="lista_acoes">
                                <ul>
                                    <li class="ui-state-default ui-corner-all" title="Excluir"  >
                                        <a href="javascript:excluir('T0004','T0004/associar&cod=<?php echo $cod?>&nom=<?php echo $nom; ?>','T007_T009','T009_codigo',<?php echo ($valores['C09']);?>,'T007_codigo',<?php echo ($valores['C07']);?>,2)" class="ui-icon ui-icon-closethick"></a>
                                    </li>
                                </ul>
                                </span>
                            </td>
			</tr>
                        <?php } if($i==0){?>
                        <tr>
                                <td colspan="5">Não Existe nenhum perfil Associado a este Programa/Menu.</td>
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
<div id="formulario">
    <span class="form-titulo">
        <p>Associar um Perfil a este Programa/Menu</p>
    </span>
    <span class="form-input">
    <form action="" method="post">
    <input type="hidden"    name="T007_codigo"  value="<?php echo $cod;?>"/>
    <input type="hidden"    name="nom"  value="<?php echo $nom;?>"/>
    <table>
        <tr>
            <td><label class="label"> Perfis (selecione apenas 1 item e clique em associar)</label></td>
        </tr>
        <tr>
            <td>
                <select name="T009_codigo" id="perfis" class="form-input-text-table-multiple" multiple>
                <?php foreach($Perfis as $campos=>$valores){ ?>
                    <option value='<?php echo $valores['COD']; ?>'><?php echo ($valores['COD']); ?> - <?php echo ($valores['NOM']); ?></option>
                <?php }?>
                </select>
            </td>
        </tr>
    </table>
        <div class="form-inpu-botoes">
            <input type="submit" value="Associar" />
        </div>
    </form>
    </span>
</div>