<?php

$objT056 = new models_T0008();
$tabela  = "T056_categoria_arquivo";



if (!is_null($_POST['T056_nome']))
{
    $insert     =   $objT056->insereT056($tabela,$_POST);    
    header('location:?router=T0008/home');
}

$user  = $_SESSION['user'];
?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0008/home">Listar</a></li>
                <li><a href="?router=T0008/novo" class="active">Novo</a></li>
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
        <input type="text" name="T056_nome" id="nome" class="validate[required] form-input-text" />
        <label class="label">Descrição</label>
        <textarea name="T056_desc" id="desc"></textarea>
        <div class="form-inpu-botoes">
            <input type="submit" value="Criar" />
        </div>
    </form>
    </span>
</div>

