<?php
//Chama classes
$cod    = $_REQUEST['cod'];
$tabela = "T002_datatype";

//Classe para Alterar usuario
$objT002 = new models_T0024();
$T002    = $objT002->buscaT002($cod);


if(!is_null($_POST['T002_codigo']))
{
    $delim         =        "T002_codigo = ".$_POST['T002_codigo'];
    //print_r($_POST);
    $Altera        =        $objT002->alteraT002($tabela,$_POST,$delim);

    header('location:?router=T0024/home');
}


$user  = $_SESSION['user'];

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0024/home">Listar</a></li>
                <li><a href="?router=T0024/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <?php foreach($T002 as $campos=>$valores){?>
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <form action="" method="post" id="formCad">
        <table>
            <tr>
                <td><label class="label">Código*    </label></td>
            </tr>
            <tr>
                <td><input type="text" name="T002_codigo" id="cod" class="form-input-text-table" value="<?php echo ($valores['P0024_T002_COD']);?>" READONLY/></td>
            </tr>
            <tr>
                <td><label class="label">Nome*    </label></td>
            </tr>
            <tr>
                <td><input type="text" name="T002_valor" id="nome" class="validate[required] form-input-text-table" value="<?php echo ($valores['P0024_T002_VAL']);?>" /></td>
            </tr>
            <tr>
                <td><label class="label">Descrição</label></td>
            </tr>
            <tr>
                <td><textarea name="T002_desc" id="desc" class="textarea-table" cols="" rows="" ><?php echo ($valores['P0024_T002_DES']);?></textarea></td>
            </tr>
        </table>
        <div class="form-inpu-botoes">
            <input type="submit" value="Alterar" />
        </div>
    </form>
    </span>
<?php } ?>
</div>

