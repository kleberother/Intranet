<?php
//Chama classes
$cod     = $_REQUEST['cod'];
$tabela  = "T077_departamento";

//Classe para Alterar usuario
$obj            = new models_T0064();
$Departamento   = $obj->retornaDepartamentoAltera($cod);

if(!is_null($_POST['T077_codigo']))
{
    $delim         =        "T077_codigo = ".$cod;
    //print_r($_POST);
    $Altera        =        $obj->alterar($tabela,$_POST,$delim);

    header('location:?router=T0033/home');
}

$user  = $_SESSION['user'];

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0033/home">Listar</a></li>
                <li><a href="?router=T0033/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <?php foreach($Departamento as $campos=>$valores){?>
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <form action="" method="post" id="formCad">
        <label class="label">Código*</label>
        <input type="text" name="T077_codigo"     id="nome"  value="<?php echo ($valores['Codigo']);?>" class="validate[required,maxSize[20]] form-input-text" READONLY />
        <label class="label">Nome*</label>
        <input type="text" name="T077_nome"       id="nome"  value="<?php echo ($valores['Nome']);?>" class="form-input-text" />
        <label class="label">Descrição*</label>
        <textarea name="T077_desc" id="desc"><?php echo ($valores['Descricao']);?></textarea>
        <div class="form-inpu-botoes">
            <input type="submit" value="Alterar" />
        </div>
    </form>
    </span>
<?php } ?>
</div>

