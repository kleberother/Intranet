<?php
//Chama classes

//CAPTURA CODIGO
$cod = $_GET['cod'];
$objPosto = new models_T0027();
$Loja     = $objPosto->retornaPostosDavo();
$Bandeira = $objPosto->retornaBandeirasPostos();
$Dados    = $objPosto->retornaPostoDados($cod);

$tabela  = "T070_postos_concorrentes";
$delim   = "T070_codigo = ".$cod;   


if (!is_null($_POST['T070_nome']))
{
    //Trata CNPJF
    $_POST['T070_cnpj']      =   $objPosto->retiraMascara($_POST['T070_cnpj']);
    //$_POST['T070_cnpj']      =   $objPosto->preencheZero("E", 14, $_POST['T070_cnpj']);
    $objPosto->altera($tabela,$_POST,$delim);
    header('location:?router=T0027/home');
}

$user  = $_SESSION['user'];

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0027/home">Listar</a></li>
                <li><a href="?router=T0027/novo" class="active">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <?php
        foreach($Dados as $campos=>$valores){
    ?>
    <form action="" method="post" id="formCad">
        <table>
            <tr>
                <td><label class="label">Posto de Referencia* </label></td>
            </tr>
            <tr>
                <td>
                    <select name="T006_codigo" class="validate[required] form-input-text-table">
                        <option value="<?php echo $valores['IdLoja']; ?>"><?php echo $valores['Loja']; ?></option>
                    </select>
                </td>
            </tr>
        </table>
    <span class="form-titulo">
        <p>Dados do Concorrente</p>
    </span>
        <table>
            <tr>
                <td><label class="label">Influência do concorrente*     </label></td>
                <td><label class="label">Distância entre postos (D´avó x Concorrente)*     </label></td>
            </tr>
            <tr>
                <td><input type="text" name="T070_influencia" class="validate[required] form-input-text-table" value="<?php echo $valores['Influencia']; ?>" /></td>
                <td><input type="text" name="T070_distancia"  class="validate[required] form-input-text-table" value="<?php echo str_replace(".", ",", $valores['Distancia']); ?>" /></td>
            </tr>
            <tr>
                <td><label class="label">Nome*    </label></td>
                <td><label class="label">CNPJ     </label></td>
                <td><label class="label">Bandeira*</label></td>
            </tr>
            <tr>
                <td><input type="text" name="T070_nome"           class="validate[required] form-input-text-table" value="<?php echo $valores['NomePosto']; ?>" /></td>
                <td><input type="text" name="T070_cnpj" id="cnpj" class="form-input-text-table"                    value="<?php echo $valores['CNPJ']; ?>"      /></td>
                <td>
                    <select name="T071_codigo" class="validate[required] form-input-text-table">
                        <option value="<?php echo $valores['IdBandeira']; ?>"><?php echo $valores['Bandeira']; ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label class="label">Endreço*     </label></td>
            </tr>
            <tr>
                <td><input type="text" name="T070_endereco" class="validate[required] form-input-text-table" value="<?php echo $valores['Endereco']; ?>" /></td>
            </tr>
        </table>
        
        <div class="form-inpu-botoes">
            <input type="submit" value="Alterar" />
        </div>
    </form>
        <?php
        }
        ?>
    </span>
</div>

