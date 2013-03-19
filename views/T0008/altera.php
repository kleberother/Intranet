<?php

$cod = $_REQUEST['codigo'];
$tabela     =   "T056_categoria_arquivo";

//Classe para Alterar usuario
$objT056 = new models_T0008();
$T056    = $objT056->buscaCategoria($cod);

if(!is_null($_POST['T056_codigo']))
{
    $delim         =        "T056_codigo = ".$_POST['T056_codigo'];
    //print_r($_POST);
    $Altera        =        $objT056->alteraT056($tabela,$_POST,$delim);

    header('location:?router=T0008/home');
}

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0008/home">Listar</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <?php foreach($T056 as $campos=>$valores){?>
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <form action="" method="post" id="formCad">
        <label class="label">Código*</label>
        <input type="text" name="T056_codigo"     id="codigo"       value="<?php echo ($valores['COD']);?>"  class="form-input-text" READONLY/>
        <label class="label">Nome*</label>
        <input type="text" name="T056_nome"       id="nome"         value="<?php echo ($valores['NOM']);?>"  class="validate[required] form-input-text" />
        <label class="label">Descrição</label>
        <textarea          name="T056_desc"       id="desc"         ><?php echo ($valores['DES']);?></textarea>
        <div class="form-inpu-botoes">
            <input type="submit" value="Alterar" />
        </div>
    </form>
    </span>
<?php } ?>
</div>

