<?php
//Pega parametros
$cod    = $_REQUEST['cod'];
$tabela = "T027_fornecedor_contato";

//Classe para ***
$objT027 = new models_T0025();
$T026    = $objT027->listaT026c($cod);
$T027    = $objT027->listaT027($cod);

if (!is_null($_POST['T026_codigo']))
{
    $Insert = $objT027->insereT027($tabela, $_POST);
    header("location:?router=T0025/contato&cod=".$cod);
}

$user = $_SESSION['user'];

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0025/home">Listar</a></li>
                <li><a href="?router=T0025/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="conteudo">
    <span class="lista_itens">
        <?php foreach($T026 as $campos=>$valores){?>
        <span class="form-titulo">
            <p><?php echo ($valores['P0025_T026_RRS']);?> / Contatos</p>
        </span>
        <?php }?>
	<table class="ui-widget ui-widget-content">
		<thead>
			<tr class="ui-widget-header ">
				<th>Código   </th>
				<th>Nome     </th>
				<th>E-mail   </th>
				<th>Ações    </th>
			</tr>
		</thead>
		<tbody>
                        <?php
                            $i = 0;
                            foreach($T027 as $campos=>$valores){
                        ?>
			<tr>
                            <td class="codigo"><?php echo ($valores['P0025_T027_COD']);?></td>
                            <td>               <?php echo ($valores['P0025_T027_NOM']);?></td>
                            <td>               <?php echo ($valores['P0025_T027_EMA']);?></td>

                            <td class="acoes">
                                <span class="lista_acoes">
                                <ul>
                                    <li class="ui-state-default ui-corner-all" title="Detalhes" ><a href="?router=T0025/contato_detalhe&cod=<?php echo $cod; ?>&codcont=<?php  echo ($valores['P0025_T027_COD']);?>"        class="ui-icon ui-icon-search" id="" ></a></li>
                                    <li class="ui-state-default ui-corner-all" title="Alterar"  ><a href="?router=T0025/contato_altera&cod=<?php echo $cod; ?>&codcont=<?php  echo ($valores['P0025_T027_COD']);?>" class="ui-icon ui-icon-pencil" id="" ></a></li><!--
                                    <li class="ui-state-default ui-corner-all" title="Telefones" ><a href="?router=T0025/contato&cod=<?php //echo ($valores['P0025_T027_COD']);?>" class="ui-icon ui-icon-contact" id="" ></a></li>-->
                                    <li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0025','T0025/contato&cod=<?php echo $cod;?>','T027_fornecedor_contato','T027_codigo',<?php echo ($valores['P0025_T027_COD']);?>)"   class="ui-icon ui-icon-closethick"></a></li>
                                </ul>
                                </span>
                            </td>
			</tr>
                       <?php $i++; } if ($i == 0){?>
                        <tr>
                            <td colspan="4">Não há usuarios associados a esse grupo!</td>
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
        <p>Cadastrar contato a esse fornecedor:</p>
    </span>
    <span class="form-input">
    <form action="" method="post">
        <table>
            <tr>
                <td colspan="2"><label class="label">Nome*  </label></td>
                <td>            <label class="label">E-mail </label></td>
            </tr>
            <tr>
                <td colspan="2"><input type="text" name="T027_nome"             id="nome"        class="form-input-text-table" /></td>
                <td>            <input type="text" name="T027_email"            id="email"       class="form-input-text-table" /></td>
            </tr>
            <tr>
                <td><label class="label">Endereço*      </label></td>
                <td><label class="label">N°</label></td>
                <td><label class="label">Cidade</label></td>
                <td><label class="label">UF</label></td>
            </tr>
            <tr>
                <td>            <input type="text" name="T027_endereco"         id="endereco"    class="form-input-text-table" /></td>
                <td>            <input type="text" name="T027_end_numero"       id="end_num"     class="form-input-text-table" /></td>
                <td>            <input type="text" name="T027_cidade"           id="cidade"      class="form-input-text-table" /></td>
                <td>            <input type="text" name="T027_uf"               id="uf"          class="form-input-text-table" /></td>
            </tr>
            <tr>
                <td><label class="label">Observações</label></td>
            </tr>
            <tr>
                <td colspan="4"><textarea         name="T027_obs"               id="obs"         class="textarea-table" cols="" rows="" ></textarea></td>
            </tr>  
        </table>
        <div class="form-inpu-botoes">
            <input type="hidden" name="T026_codigo" id="cod_for" value="<?php echo $cod ?>" />
            <input type="submit" value="Enviar" />
        </div>
    </form>
    </span>
</div>