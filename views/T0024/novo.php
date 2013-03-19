<?php
//Chama classes
$objT002 = new models_T0024();
$tabela = "T002_datatype";

if (!is_null($_POST['T002_valor']))
{
    $Insert = $objT002->insereT002($tabela, $_POST);
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
                <li><a href="?router=T0024/novo" class="active">Novo</a></li>
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
                <td><label class="label">Valor*    </label></td>
            </tr>
            <tr>
                <td><input type="text" name="T002_valor" id="valor" class="validate[required] form-input-text-table" /></td>
            </tr>
            <tr>
                <td><label class="label">Descrição</label></td>
            </tr>
            <tr>
                <td><textarea name="T002_desc" id="desc" class="textarea-table" cols="" rows="" ></textarea></td>
            </tr> 
        </table>
        <div class="form-inpu-botoes">
            <input type="submit" value="Criar" />
        </div>
    </form>
    </span>
</div>

