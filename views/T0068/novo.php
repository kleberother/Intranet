<?php

$obj        =   new models_T0068();
$Template   =   $obj->retornaTemplate();  

if (!empty($_POST))
{
    $tabela =   "T033_corpo";
    
    $obj->inserir($tabela, $_POST);
    header("location:?router=T0068/home");
}

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0068/home">Listar</a></li>
                <li><a href="?router=T0068/novo" class="active">Novo</a></li>
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
        <label class="label">Template*</label>
        <select            name="T076_codigo"  >
            <option value="">Selecione..</option>
        <?php foreach($Template as $campos=>$valores){?>
            <option value="<?php echo $valores['CodigoTemplate']?>"><?php echo ($valores['NomeTemplate'])?></option>
        <?php }?>
        </select>        
        <label class="label">Nome</label>
        <input type="text" name="T033_nome" id="nome" class="form-input-text" />
        <label class="label">Descrição</label>
        <textarea          name="T033_desc" id="desc" rows="" cols=""></textarea>
        <label class="label">Corpo (html)</label>
        <textarea          name="T033_corpo" id="desc" rows="" cols="" maxlength="5000"></textarea>
        <div class="form-inpu-botoes">
            <input type="submit"            value="Criar" />
        </div>
    </form>
    </span>
</div>

