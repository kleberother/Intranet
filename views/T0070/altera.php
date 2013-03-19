<?php
//Chama classes
$cod        =   $_REQUEST['cod'];
$tabela     =   "T033_corpo";
//Classe para Alterar usuario
$obj        =   new models_T0068();
$Corpo      =   $obj->retornaCorpos($cod);          
$Template   =   $obj->retornaTemplate();

if(!empty($_POST))
{
    $delim         =        "T033_codigo = ".$_POST['T033_codigo'];
    $obj->altera($tabela,$_POST,$delim,$cod);
    header('location:?router=T0068/home');
}

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0068/home">Listar</a></li>
                <li><a href="?router=T0068/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <?php foreach($Corpo as $campos=>$valores){ ?>
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <form action="" method="post" id="formCad">
        <label class="label">Código</label>
        <input type="text" name="T033_codigo"   id="nome"  value="<?php echo $valores['CodigoCorpo'];?>" class="form-input-text" readonly  />
        <label class="label">Template*</label>
        <select             name="T076_codigo"  >
        <?php foreach($Template as $cpTemplate=>$vlTemplate){?>
            <option value="<?php echo $vlTemplate['CodigoTemplate']?>" <?php echo ($vlTemplate['CodigoTemplate']=$valores['CodigoTemplate'])?"selected":"" ?>><?php echo $obj->preencheZero("E", 3,$vlTemplate['CodigoTemplate'])." - ".$vlTemplate['NomeTemplate']?></option>
        <?php }?>
        </select> 
        <label class="label">Nome</label>
        <input type="text" name="T033_nome"     id="nome"  value="<?php echo $valores['NomeCorpo'];?>" class="form-input-text"           />
        <label class="label">Descrição</label>
        <textarea name="T033_desc" id="desc"><?php echo $valores['DescricaoCorpo'];?></textarea>
        <label class="label">Corpo</label>
        <textarea name="T033_corpo" id="desc"><?php echo $valores['Corpo'];?></textarea>
        <div class="form-inpu-botoes">
            <input type="submit" value="Alterar" />
        </div>
    </form>
    </span>
<?php } ?>
</div>

