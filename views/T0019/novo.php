<?php
//Chama classes
$tabela = "T054_avisos";
//Classe para buscar loja
$objAvisos = new models_T0019();
if (!is_null($_POST['T054_texto']))
{
    $Insert = $objAvisos->inserir($tabela, $_POST);
    //header('location:?router=T0019/home');
}

$user  = $_SESSION['user'];

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0019/home">Listar</a></li>
                <li><a href="?router=T0019/novo" class="active">Novo</a></li>
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
                <td colspan="4"><label class="label">Texto*</label></td>
            </tr>
            <tr>
                <td colspan="4"><textarea name="T054_texto" id="texto" class="validate[required] textarea-table" cols="" rows="" ></textarea></td>
            </tr>  
            <tr>
                <td><label class="label">Data Inicial*    </label></td>
                <td><label class="label">Hora Inicial*</label></td>
                <td><label class="label">Data Final*    </label></td>
                <td><label class="label">Hora Final*    </label></td>
            </tr>
            <tr>
                <td><input type="text" name="T054_dt_inicio"  id="dt_inicial"    class="validate[required] form-input-text-table" /></td>
                <td><input type="text" name="T054_hr_inicio"  id="hr_inicial"    class="validate[required] form-input-text-table" /></td>
                <td><input type="text" name="T054_dt_fim"     id="dt_final"      class="validate[required] form-input-text-table" /></td>
                <td><input type="text" name="T054_hr_fim"     id="hr_final"      class="validate[required] form-input-text-table" /></td>
            </tr>
        </table>
        <div class="form-inpu-botoes">
            <input type="submit" value="Criar" />
        </div>
    </form>
    </span>
</div>

