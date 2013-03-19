<?php
//Chama classes
$cod    = $_REQUEST['cod'];
$codcont = $_REQUEST['codcont'];
$tabela = "T027_fornecedor_contato";

//Classe para Alterar usuario
$objT027 = new models_T0025();
$T027    = $objT027->buscaT027($cod,$codcont);

if(!is_null($_POST['T027_codigo']))
{
    $delim         =        "T027_codigo = ".$_POST['T027_codigo']." AND T026_codigo = ".$_POST['T026_codigo'];
    //print_r($_POST);
    $Altera        =        $objT027->alteraT027($tabela,$_POST,$delim);

    header('location:?router=T0025/contato&cod='.$cod);
}

$user  = $_SESSION['user'];

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
<div id="formulario">
    <?php foreach($T027 as $campos=>$valores){?>
    <span class="form-titulo">
        <p>Alterar cadastro de contato</p>
    </span>
    <span class="form-input">
    <form action="" method="post">
        <table>
            <tr>
                <td colspan="2"><label class="label">Código*  </label></td>
                <td>            <label class="label">Código Fornecedor </label></td>
            </tr>
            <tr>
                <td colspan="2"><input type="text" name="T027_codigo"            id="nome"       class="form-input-text-table"  value="<?php echo $codcont; ?>" READONLY/></td>
                <td>            <input type="text" name="T026_codigo"            id="email"       class="form-input-text-table" value="<?php echo $cod; ?>"     READONLY/></td>
            </tr>
            <tr>
                <td colspan="2"><label class="label">Nome*  </label></td>
                <td>            <label class="label">E-mail </label></td>
            </tr>
            <tr>
                <td colspan="2"><input type="text" name="T027_nome"             id="nome"        class="form-input-text-table" value="<?php echo ($valores['P0025_T027_NOM']);?>"/></td>
                <td>            <input type="text" name="T027_email"            id="email"       class="form-input-text-table" value="<?php echo ($valores['P0025_T027_EMA']);?>"/></td>
            </tr>
            <tr>
                <td><label class="label">Endereço*      </label></td>
                <td><label class="label">N°</label></td>
                <td><label class="label">Cidade</label></td>
                <td><label class="label">UF</label></td>
            </tr>
            <tr>
                <td>            <input type="text" name="T027_endereco"         id="endereco"    class="form-input-text-table" value="<?php echo ($valores['P0025_T027_END']);?>" /></td>
                <td>            <input type="text" name="T027_end_numero"       id="end_num"     class="form-input-text-table" value="<?php echo ($valores['P0025_T027_NUM']);?>"/></td>
                <td>            <input type="text" name="T027_cidade"           id="cidade"      class="form-input-text-table" value="<?php echo ($valores['P0025_T027_CID']);?>"/></td>
                <td>            <input type="text" name="T027_uf"               id="uf"          class="form-input-text-table" value="<?php echo ($valores['P0025_T027_UF']);?>"/></td>
            </tr>
            <tr>
                <td><label class="label">Observações</label></td>
            </tr>
            <tr>
                <td colspan="4"><textarea         name="T027_obs"               id="obs"         class="textarea-table" cols="" rows="" ><?php echo ($valores['P0025_T027_OBS']);?></textarea></td>
            </tr>
        </table>
        <div class="form-inpu-botoes">
            <input type="hidden" name="T026_codigo" id="cod_for" value="<?php echo $cod ?>" />
            <input type="submit" value="Enviar" />
        </div>
    </form>
    </span>
    <?php } ?>
</div>

