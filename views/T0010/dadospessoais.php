<?php
// Recupera variáveis
$user  = $_SESSION['user'];

// Objeto de Conexão
$objAltUsu = new models_T0010();
    
//Classe para buscar loja
$objListLoja = new models_T0010();
$ListLoja    = $objListLoja->listaLojas();

// Altera usuário
if (!empty ($_POST['T004_nome']))
{
    $delim         =        "T004_login = '".$user."'";
    $alterar = $objAltUsu->alterar("T004_usuario",$_POST,$delim);
}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               

$AltUsu    = $objAltUsu->buscaUsuario($user);
?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0010/home">Listar</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <?php foreach($AltUsu as $campos=>$valores){?>
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <form action="" method="post">
        <label class="label">Nome Completo*</label>
        <input type="text" name="T004_nome"         id="nome"          value="<?php echo ($valores['Nome']);?>"         class="form-input-text" />
        <label class="label">Nome*</label>
        <input type="text" name="T004_nome_display" id="nome_display"  value="<?php echo ($valores['DisplayNome']);?>"  class="form-input-text" />
        <label class="label">Função*</label>
        <input type="text" name="T004_funcao"       id="funcao"        value="<?php echo ($valores['Funcao']);?>"       class="form-input-text" />
        <label class="label">Departamento*</label>
        <input type="text" name="T004_departamento" id="departamento"  value="<?php echo ($valores['Departamento']);?>" class="form-input-text" />
        <label class="label">Ramal*</label>
        <input type="text" name="T004_ramal"        id="ramal"         value="<?php echo ($valores['Ramal']);?>"        class="form-input-text" />
        <label class="label">Celular*</label>
        <input type="text" name="T004_celular"      id="celular"       value="<?php echo ($valores['Celular']);?>"      class="form-input-text" />
        <label class="label">Loja*</label>
        <select name="T006_codigo" id="loja" class="form-input-text">
        <?php foreach($ListLoja as $campos2=>$valores2){ ?>
            <option value='<?php echo $valores2['CodigoLoja']; ?>' <?php if($valores2['CodigoLoja'] == $valores['CodigoLoja']) echo "selected"; ?>><?php echo $objAltUsu->preencheZero("E", 3, $valores2['CodigoLoja'])." - ".$valores2['NomeLoja']; ?></option>
        <?php }?>
        </select>
        <div class="form-inpu-botoes">
            <input type="submit" value="Alterar" />
        </div>
    </form>
    </span>
<?php } ?>
</div>
    
