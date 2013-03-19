<?php
//Chama classes
$objT045 = new models_T0018();
$tabela = "T045_categoria_artigos";

if (!is_null($_POST['T045_nome']))
{
    $Insert = $objT045->insereT045($tabela, $_POST);
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
                <li><a href="?router=T0018/novo" class="active">Novo</a></li>
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
                <td><label class="label">Nome*    </label></td>
            </tr>
            <tr>
                <td><input type="text" name="T045_nome" id="nf_num" class="validate[required] form-input-text-table" /></td>
            </tr>
            <tr>
                <td><label class="label">Descrição</label></td>
            </tr>
            <tr>
                <td><textarea name="T045_desc" id="espa" class="textarea-table" cols="" rows="" ></textarea></td>
            </tr> 
        </table>
        <div class="form-inpu-botoes">
            <input type="submit" value="Criar" />
        </div>
    </form>
    </span>
</div>

