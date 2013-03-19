<?php

$obj        =   new models_T0069();
$Template   =   $obj->retornaTemplate();  
$Corpo      =   $obj->retornaCorpoTemplate();

print_r($_POST);

if (!empty($_POST))
{
    $tabela =   "T058_dados_variaveis";
    
    $obj->inserir($tabela, $_POST);
    header("location:?router=T0069/home");
}

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0069/home">Listar</a></li>
                <li><a href="?router=T0069/novo" class="active">Novo</a></li>
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
        <label class="label">Corpo Template*</label>
        <select            name="T033_codigo"  >
            <option value="">Selecione..</option>
        <?php foreach($Corpo as $campos=>$valores){?>
            <option value="<?php echo $valores['CodigoCorpo']?>"><?php echo ($valores['NomeCorpo'])?></option>
        <?php }?>
        </select>               
        <label class="label">Tipo Origem</label>
        <select            name="T058_tp_orig"  >
        <option value="">Selecione..</option>
        <option value="1">001 - </option>
        <option value="2">002 - </option>
        <option value="3">003 - </option>
        </select> 
        <label class="label">Origem Database</label>
        <input type="text" name="T058_orig_database"    class="form-input-text"   maxlength="20"  />
        <label class="label">Origem Tabela</label>
        <input type="text" name="T058_orig_tabela"      class="form-input-text"   maxlength="60"  />
        <label class="label">Origem Coluna</label>
        <input type="text" name="T058_orig_coluna"      class="form-input-text"   maxlength="60"  />
        <label class="label">Condição</label>
        <textarea          name="T058_condicao"         rows="" cols=""           maxlength="200" ></textarea>
        <label class="label">Cmd</label>
        <textarea          name="T058_cmd"              rows="" cols=""           maxlength="200" ></textarea>
        <div class="form-inpu-botoes">
            <input type="submit"            value="Criar" />
        </div>
    </form>
    </span>
</div>

