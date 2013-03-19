<?php

$codigo =   $_REQUEST['codigo'];

$objCategoria  = new models_T0008();

$Categoria    = $objCategoria->buscaCategoria($codigo);


?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0008/home">Listar</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <?php foreach($Categoria as $campos=>$valores){?>
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <form action="?router=T0008/home">
        <label>Código</label>
        <input type="text" name="T056_codigo"     id="codigo"       value="<?php echo ($valores['COD']);?>"  class="form-input-text" READONLY/>
        <label>Nome*</label>
        <input type="text" name="T056_nome"       id="nome"         value="<?php echo ($valores['NOM']);?>"  class="form-input-text" maxlenght="3"/>
        <label>Descrição</label>
        <textarea          name="T056_desc"       id="desc"         ><?php echo ($valores['DES']);?></textarea>
        <div class="form-inpu-botoes">
            <input type="submit" value="Enviar" />
        </div>
    </form>
    </span>
<?php } ?>
</div>

