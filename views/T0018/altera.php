<?php
//Chama classes
$cod    = $_REQUEST['cod'];
$tabela = "T045_categoria_artigos";

//Classe para Alterar usuario
$objT045 = new models_T0018();
$T045    = $objT045->buscaT045($cod);

if(!is_null($_POST['T045_codigo']))
{
    $delim         =        "T045_codigo = ".$_POST['T045_codigo'];
    //print_r($_POST);
    $Altera        =        $objT045->alteraT045($tabela,$_POST,$delim);

    header('location:?router=T0018/home');
}


$user  = $_SESSION['user'];

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0018/home">Listar</a></li>
                <li><a href="?router=T0018/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <?php foreach($T045 as $campos=>$valores){?>
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
                <td><input type="text" name="T045_codigo" id="cod" class="form-input-text-table" value="<?php echo ($valores['P0018_T045_COD']);?>" READONLY/></td>
            </tr>
            <tr>
                <td><label class="label">Nome*    </label></td>
            </tr>
            <tr>
                <td><input type="text" name="T045_nome" id="nome" class="validate[required] form-input-text-table" value="<?php echo ($valores['P0018_T045_NOM']);?>" /></td>
            </tr>
            <tr>
                <td><label class="label">Descrição</label></td>
            </tr>
            <tr>
                <td><textarea name="T045_desc" id="desc" class="textarea-table" cols="" rows="" ><?php echo ($valores['P0018_T045_DES']);?></textarea></td>
            </tr>
        </table>
        <div class="form-inpu-botoes">
            <input type="submit" value="Alterar" />
        </div>
    </form>
    </span>
<?php } ?>
</div>

