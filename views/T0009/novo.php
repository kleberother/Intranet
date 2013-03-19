<?php
//Chama classes

//
$objT046 = new models_T0017();
$T045    = $objT046->listaT045();

$tabela  = "T046_artigos";



if (!is_null($_POST['T045_codigo']))
{
    $insert = $objT046->insereT046($tabela,$_POST);
    header('location:?router=T0017/home');
}
$user  = $_SESSION['user'];

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0017/home">Listar</a></li>
                <li><a href="?router=T0017/novo" class="active">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <form action="" method="post" id="formCad">
        <table>
            <tr>
                <td><label class="label">Titulo*     </label></td>
                <td><label class="label">Categoria*    </label></td>
                <td><label class="label">Data Inicial* </label></td>
                <td><label class="label">Data Final*  </label></td>
            </tr>
            <tr>
                <td><input type="text" name="T046_titulo" id="titulo" class="validate[required] form-input-text-table" /></td>
                <td>
                    <select name="T045_codigo" id="categoria" class="validate[required] form-input-text-table">
                        <option value="">Selecione...</option>
                    <?php foreach($T045 as $campos=>$valores){ ?>
                        <option value='<?php echo $valores['P0017_T045_COD']; ?>'><?php echo ($valores['P0017_T045_NOM']); ?></option>
                    <?php }?>
                    </select>
                </td>
                <td><input type="text" name="T046_data_inicial" id="dt_inicial" class="validate[required] form-input-text-table" /></td>
                <td><input type="text" name="T046_data_final"   id="dt_final" class="validate[required] form-input-text-table" /></td>
            </tr>
            <tr>
                <td colspan="4"><label class="label">Chamada</label></td>
            </tr>
            <tr>
                <td colspan="4"><textarea name="T046_chamada" id="chamada" class="textarea-table" cols="" rows="" ></textarea></td>
            </tr>
            <tr>
                <td colspan="4"><label class="label">Texto*</label></td>
            </tr>
            <tr>
                <td colspan="4">
                    <textarea name="T046_texto" id="texto" class="validate[required] textarea-table" cols="" rows="" ></textarea>
                    <input type="hidden" name="T004_login" value="<?php echo $user; ?>"
                </td>
            </tr> 
        </table>
        <div class="form-inpu-botoes">
            <input type="hidden" name="T046_data_publicacao" value="<?php echo $data_atual  = date("d/m/Y"); ?>" />
            <input type="hidden" name="T004_login" value="<?php echo $user ?>" />
            <input type="submit" value="Criar" />
        </div>
    </form>
    </span>
</div>

