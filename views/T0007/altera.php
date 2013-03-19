<?php
//Chama classes
$cod = $_REQUEST['codigo'];
$tabela     =   "T057_extensao";

//Classe para Alterar usuario
$objExtensoes = new models_T0007();
$Extensoes    = $objExtensoes->selecionaExtensao($cod);

if(!is_null($_POST['T057_codigo']))
{
    $delim         =        "T057_codigo = ".$_POST['T057_codigo'];
    //print_r($_POST);
    $Altera        =        $objExtensoes->alteraT057($tabela,$_POST,$delim);

    header('location:?router=T0007/home');
}
?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0007/home">Listar</a></li>
                <li><a href="?router=T0007/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <?php foreach($Extensoes as $campos=>$valores){?>
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <form action="" method="post" id="formCad">
        <input type="text" name="T057_codigo"     id="codigo"       value="<?php echo ($valores['COD']);?>"  class="form-input-text" READONLY/>
        <label class="label">Nome*</label>
        <input type="text" name="T057_nome"       id="nome"         value="<?php echo ($valores['NOM']);?>"  class="validate[required,maxSize[4]] form-input-text" maxlenght="3"/>
        <label class="label">Descrição</label>
        <textarea          name="T057_desc"       id="desc"         ><?php echo ($valores['DES']);?></textarea>
        <div class="form-inpu-botoes">
            <input type="submit" value="Alterar" />
        </div>
    </form>
    </span>
<?php } ?>
</div>

