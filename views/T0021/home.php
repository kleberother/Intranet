<?php
//Chama classes

//
$objT056 = new models_T0021();
$T056    = $objT056->listaT056();

$objT002 = new models_T0021();
$T002    = $objT002->listaT002();

$user = $_SESSION['user'];

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0021/home" class="active">Listar</a></li>
                <li><a href="?router=T0021/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <form action="#">
        <table>
            <tr>
                <td><label class="label">Tipo de Arquivo*</label></td>
            </tr>
            <tr>
                <td>
                    <select name="T056_codigo" id="tipo_arquivo" class="form-input-text-table">
                        <option>Selecione...</option>
                    <?php foreach($T056 as $campos=>$valores){ ?>
                        <option value='<?php echo $valores['P0021_T056_COD']; ?>'><?php echo ($valores['P0021_T056_NOM']); ?></option>
                    <?php }?>
                    </select>
                </td>
            </tr>
        </table>
        <table class="form-inpu-tab">
            <thead>
                <tr>
                    <td><label class="label">Nome</label></td>
                    <td><label class="label">Data Type</label></td>
                    <td><label class="label">Tamanho</label></td>
                    <td><label class="label">Obrigatório</label></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="background:<?php echo $cor; ?>"><input type="text" name="T062_nome"      id="desd"   size="20"  maxlength="" /></td>
                    <td style="background:<?php echo $cor; ?>">
                        <select name="T002_codigo" id="datatype" class="form-input-text-table">
                            <option>Selecione...</option>
                        <?php foreach($T002 as $campos=>$valores){ ?>
                            <option value='<?php echo $valores['P0021_T002_COD']; ?>'><?php echo ($valores['P0021_T002_VAL']); ?></option>
                        <?php }?>
                        </select>
                    </td>
                    <td style="background:<?php echo $cor; ?>"><input type="text" name="T062_tamanho" id="tamanho"   size="1"  maxlength="" /></td>
                    <td style="background:<?php echo $cor; ?>">
                        <select name="T062_obrigatorio" id="obrigatorio" class="form-input-text-table">
                            <option>Selecione...</option>
                            <option value="s">Sim</option>
                            <option value="n">Não</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="form-inpu-botoes">
            <input type="submit" value="Cadastrar" />
        </div>
    </form>
    </span>
</div>