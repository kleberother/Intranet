<?php 

//Pega parametros
$cod = $_REQUEST['cod'];

//Classe para ***
$objGrpWF2 = new models_T0014();
$GrpWF2    = $objGrpWF2->selecionaGrpWork2($cod);

//Classe para ***
$objProcesso = new models_T0014();
$Processo    = $objProcesso->selecionaProcesso();

$user = $_SESSION['user'];

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
    <?php foreach($GrpWF2 as $campos=>$valores){?>
    <form action="#">
        <label class="label">Nome*</label>
        <input type="text" name="T059_nome" id="nome" class="form-input-text" value="<?php echo ($valores['N59']);?>" />
        <label class="label">Descrição</label>
        <textarea name="T059_desc" id="desc" cols="" rows=""><?php echo ($valores['D59']);?></textarea>
        <label class="label">Processo*</label>
        <select name="T061_codigo" id="processo">
        <?php foreach($Processo as $campos=>$valores){?>
            <option value="<?php echo $valores['COD']?>"><?php echo ($valores['NOM'])?></option>
        <?php }?>
        </select>
        <div class="form-inpu-botoes">
            <input type="submit" value="Enviar" />
        </div>
    </form>
    <?php }?>
    </span>
</div>
