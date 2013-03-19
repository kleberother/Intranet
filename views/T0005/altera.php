<?php
//Chama classes
$cod = $_REQUEST['cod'];
$tabela     =   "T009_perfil";

//Classe para Alterar usuario
$objPerfil = new models_T0005();
$Perfil    = $objPerfil->selecionaPerfil($cod);

if(!is_null($_POST['T009_codigo']))
{
    $delim         =        "T009_codigo = ".$_POST['T009_codigo'];
    //print_r($_POST);
    $Altera        =        $objPerfil->alteraT009($tabela,$_POST,$delim);

    header('location:?router=T0005/home');
}

$user  = $_SESSION['user'];

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0005/home">Listar</a></li>
                <li><a href="?router=T0005/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <?php foreach($Perfil as $campos=>$valores){?>
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <form action="" method="post" id="formCad">
        <label class="label">Código*</label>
        <input type="text" name="T009_codigo"     id="nome"  value="<?php echo ($valores['COD']);?>" class="validate[required,maxSize[20]] form-input-text" READONLY />
        <label class="label">Nome*</label>
        <input type="text" name="T009_nome"       id="nome"  value="<?php echo ($valores['NOM']);?>" class="form-input-text" />
        <label class="label">Descrição*</label>
        <textarea name="T009_desc" id="desc"><?php echo ($valores['DES']);?></textarea>
        <div class="form-inpu-botoes">
            <input type="submit" value="Alterar" />
        </div>
    </form>
    </span>
<?php } ?>
</div>

