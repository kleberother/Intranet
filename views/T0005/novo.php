<?php
//Chama classes
$objT009 = new models_T0005();
$tabela = "T009_perfil";

if (!is_null($_POST['T009_nome']))
{
    $Insert = $objT009->insereT009($tabela, $_POST);
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
                <li><a href="?router=T0005/novo" class="active">Novo</a></li>
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
        <label class="label">Nome*</label>
        <input type="text" name="T009_nome" id="nome" class="validate[required,maxSize[60]] form-input-text" />
        <label class="label">Descrição</label>
        <textarea name="T009_desc" id="desc"></textarea>
        <div class="form-inpu-botoes">
            <input type="submit" value="Criar" />
        </div>
    </form>
    </span>
</div>

