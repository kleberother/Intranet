<?php
//Classe para ***
$objT059 = new models_T0014();
$tabela  = "T059_grupo_workflow";
$user  = $_SESSION['user'];
$Processo    = $objT059->selecionaProcesso();

if (!is_null($_POST['T061_codigo']))
{
    $insert = $objT059->insereT059($tabela,$_POST);
    header('location:?router=T0014/home');
}

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0014/home">Listar</a></li>
                <li><a href="?router=T0014/novo" class="active">Novo</a></li>
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
        <label class="label">Processo*</label>
        <select name="T061_codigo" id="processo" class="validate[required]">
            <option value="">Selecione...</option>
        <?php foreach($Processo as $campos=>$valores){?>
            <option value="<?php echo $valores['COD']?>"><?php echo ($valores['NOM'])?></option>
        <?php }?>
        </select>
        <label class="label">Nome*</label>
        <input type="text" name="T059_nome" id="nome" class="validate[required] form-input-text" />
        <label class="label">Descrição</label>
        <textarea name="T059_desc" id="desc" cols="" rows=""></textarea>
        <input type="hidden" name="T004_login" id="login" value="<?php echo $user; ?>" />
        <div class="form-inpu-botoes">
            <input type="submit" value="Criar" />
        </div>
    </form>
    </span>
</div>
