<?php

//Pega parametros
$cod        =   $_REQUEST['cod'];
$tabela     =   "T059_grupo_workflow";


//Classe para ***
$objT059 = new models_T0014();
$GrpWF    = $objT059->selecionaGrpWork2($cod);

$Processo    = $objT059->selecionaProcesso();

if(!is_null($_POST['T059_codigo']))
{
    $delim         =        "T059_codigo = ".$_POST['T059_codigo'];

    $Altera        =        $objT059->alteraT059($tabela,$_POST,$delim);

    header('location:?router=T0014/home');
}
?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0014/home">Listar</a></li>
                <li><a href="?router=T0014/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <?php foreach($GrpWF as $campos=>$valores){?>
    <form action="" method="post" id="formCad">
        <label class="label">Código*</label>
        <input type="text" name="T059_codigo" id="nome" class="form-input-text" value="<?php echo ($valores['C59']);?>" READONLY />
        <label class="label">Nome*</label>
        <input type="text" name="T059_nome" id="nome" class="validate[required] form-input-text" value="<?php echo ($valores['N59']);?>" />
        <label class="label">Descrição</label>
        <textarea name="T059_desc" id="desc" cols="" rows=""><?php echo ($valores['D59']);?></textarea>
        <label class="label">Processo*</label>
        <select name="T061_codigo" id="processo" class="validate[required]">
        <?php foreach($Processo as $campos=>$valores){?>
            <option value="<?php echo $valores['COD']?>"><?php echo ($valores['NOM'])?></option>
        <?php }?>
        </select>
        <div class="form-inpu-botoes">
            <input type="submit" value="Alterar" />
        </div>
    </form>
    <?php }?>
    </span>
</div>
