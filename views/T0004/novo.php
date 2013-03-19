<?php
//Chama classes

//Classe para Usuarios
$objPai = new models_T0004();
$Pai    = $objPai->listarPai();
$tabela = "T007_estrutura";

if (!is_null($_POST['T007_nome']))
{
    $Insert = $objPai->insereEstrutura($tabela, $_POST);
    //header('location:?router=T0004/home');
}

$user  = $_SESSION['user'];

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0004/home">Listar</a></li>
                <li><a href="?router=T0004/novo" class="active">Novo</a></li>
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
        <label class="label">Nome*</label>
        <input type="text" name="T007_nome" id="nome" class="validate[required,maxSize[20]] form-input-text" />
        <label class="label">Descrição</label>
        <textarea          name="T007_desc" id="desc" rows="" cols=""></textarea>
        <label class="label">Titulo</label>
        <input type="text" name="T007_titulo" id="titulo" class="form-input-text" />
        <label class="label">Pai*</label>
        <select            name="T007_pai"  id="pai">
            <option value="">Selecione..</option>
            <option value="null">Sem Pai</option>
        <?php foreach($Pai as $campos=>$valores){?>
            <option value="<?php echo $valores['COD']?>"><?php echo ($valores['NOM'])?></option>
        <?php }?>
        </select>
        <label class="label">Programa</label>
        <input type="text" name="T007_prog" id="prog" class="form-input-text" />
        <label class="label">Tipo*</label>
        <div id="radio">
           <input type="radio" id="radio1" name="T007_tp" value="0" class="validate[required]" /><label for="radio1">Privado</label>
           <input type="radio" id="radio2" name="T007_tp" value="1" class="validate[required]" /><label for="radio2">Público</label>
        </div>
        <div id="radio">
           <input type="radio" id="radio3" name="T007_extranet" value="0" class="validate[required]" /><label for="radio3">Intranet</label>
           <input type="radio" id="radio4" name="T007_extranet" value="1" class="validate[required]" /><label for="radio4">Extranet</label>
        </div>
        <div class="form-inpu-botoes">
            <input type="submit"            value="Criar" />
        </div>
    </form>
    </span>
</div>

