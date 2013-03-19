<?php
// Recupera variáveis
$login = $_REQUEST['login'];
$user  = $_SESSION['user'];

// Objeto de Conexão
$objAltUsu = new models_T0010();

$AltUsu    = $objAltUsu->buscaUsuario($login);

    

//Classe para buscar loja
$objListLoja = new models_T0010();
$ListLoja    = $objListLoja->listaLojas();

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
    <form action="#">  
        <label class="label">Nome*</label>
        <input type="text" name="T004_nome"       id="nome"  value="<?php echo ($valores['NOME']);?>" class="form-input-text" />
        <label class="label">Matrícula</label>
        <input type="text" name="T004_matricula"  id="matricula"  value="<?php echo ($valores['MATR']);?>" class="form-input-text" />
        <label class="label">Loja*</label>
        <select name="T006_codigo" id="loja" class="form-input-text">
        <?php foreach($ListLoja as $campos2=>$valores2){ ?>
            <option value='<?php echo $valores2['LCODI']; ?>' <?php if($valores2['LCODI'] == $valores['COLO']) echo "selected"; ?>><?php echo ($valores2['LNOME']); ?></option>
        <?php }?>
        </select>
        <div class="form-inpu-botoes">
            <input type="submit" value="Alterar" />
        </div>
    </form>
    </span>
<?php } ?>
</div>
    
