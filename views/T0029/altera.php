<script src='template/js/interno/T0004/mensagens.js'></script>
<?php
//Chama classes
$cod        =       $_REQUEST['cod'];
$tabela     =       "T007_estrutura";
//Classe para Alterar usuario

$objEstrutura  =       new models_T0004();


?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0029/home">Listar</a></li>
                <li><a href="?router=T0029/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <?php foreach($Estrutura as $campos=>$valores){?>
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <form action="" method="post" id="formCad">
        <label class="label">Código</label>
        <input type="text" name="T007_codigo"   id="nome"  value="<?php echo $valores['COD'];?>" class="form-input-text" readonly  />
        <label class="label">Nome*</label>
        <input type="text" name="T007_nome"     id="nome"  value="<?php echo $valores['NOM'];?>" class="validate[required,maxSize[20]] form-input-text"           />
        <label class="label">Descrição</label>
        <textarea name="T007_desc" id="desc"><?php echo $valores['DES'];?></textarea>
        <label class="label">Programa/Menu Pai</label>
        <input type="text" name="T007_pai"      id="nome"  value="<?php echo $valores['PAI'];?>" class="form-input-text"           />
        <label class="label">Programa Inicial</label>
        <input type="text" name="T007_prog"     id="nome"  value="<?php echo $valores['PRO'];?>" class="form-input-text"           />
        <label class="label">Tipo*</label>
        <div id="radio">
           <?php if($valores['TIP']==0){?>
           <input type="radio" id="radio1" name="T007_tp" value="0" class="validate[required]" checked/><label for="radio1">Privado</label>
           <input type="radio" id="radio2" name="T007_tp" value="1" class="validate[required]" /><label for="radio2">Público</label>
           <?php }else {?>
           <input type="radio" id="radio1" name="T007_tp" value="0" class="validate[required]" /><label for="radio1">Privado</label>
           <input type="radio" id="radio2" name="T007_tp" value="1" class="validate[required]" checked/><label for="radio2">Público</label>
           <?php }?>
        </div>
        <div class="form-inpu-botoes">
            <input type="submit" value="Alterar" />
        </div>
    </form>
    </span>
<?php } ?>
</div>

