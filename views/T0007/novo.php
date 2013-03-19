<?php

$objT057 = new models_T0007();
$tabela = "T057_extensao";



if (!is_null($_POST['T057_nome']))
{
    $insert = $objT057->insereT057($tabela,$_POST);
    header('location:?router=T0007/home');
}

$user  = $_SESSION['user'];
?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0007/home">Listar</a></li>
                <li><a href="?router=T0007/novo" class="active">Novo</a></li>
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
        <input type="text" name="T057_nome" id="nome" class="validate[required,maxSize[4]] form-input-text" />
        <label class="label">Descrição*</label>
        <textarea name="T057_desc" id="desc"></textarea>
        <div class="form-inpu-botoes">
            <input type="submit" value="Criar" />
        </div>
    </form>
    </span>
</div>

