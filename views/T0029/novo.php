<?php
//Cria objeto de conexão com as models
$obj       = new models_T0029();
//Variavel retorna todos os tipos de arquivos para listar o filtro de tipo de arquivo
$TipArq       = $obj->retornaTipoArquivos();
// Variavel para deixar como default em Owner nos filtros de arquivos e upload de arquivo
$owner          = $_SESSION['displayName']." - ".$_SESSION['user'];

?>
<script type="text/javascript" src="template/js/interno/T0029/T0029.js"></script>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0029/home"                >Listar</a></li>
                <li><a href="?router=T0029/novo" class="active" >Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<script src="template/js/interno/T0029/upload.js"></script> 
<div id="dialog-upload" title="Upload" style="display:none">
	<p    class="validateTips">Selecione um tipo e um arquivo para carregar no sistema!</p>
        <span class="form-input">
	<form action="?router=T0029/js.upload" method="post" id="form-upload"  enctype="multipart/form-data">
	<fieldset>
            
                <label class="label">Escolha o Arquivo*</label>
                <input type="file"      name="P0029_arquivo"      id="arquivo" class="form-input-text"   />
        </fieldset>
	</form>
        </span>
</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Upload Arquivo</a></li>
    </ul>
    <div id="tabs-2">
        <form action="?router=T0029/js.upload" method="post" id="formCad"  enctype="multipart/form-data">
        <div id="formulario">
            <span  class="form-input">
                <table class="form-inpu-tab">
                    <thead>
                        <tr>
                            <td><label class="label">Nome*</label></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="T055_nome" id="nome" class="validate[required,maxSize[50]] form-input-select" maxlength="40" /></td>
                        </tr>
                        <tr>
                            <td><label class="label">Descrição</label></td>
                        </tr>
                        <tr>
                            <td><textarea name="T055_desc"  class="textarea-table" cols="" rows="" width="40"></textarea></td>
                        </tr>
                        <tr>
                            <td><label class="label">Tipo de Arquivo*</label></td>
                        </tr>
                        <tr>
                            <td>
                                <select name="T056_codigo"  id="tp_codigo" class="validate[required] form-input-select">
                                    <option value="">Selecione...</option>
                                <?php foreach($TipArq as $campos=>$valores){?>
                                    <option value="<?php echo $valores['Codigo']?>"><?php echo ($valores['Nome'])?></option>
                                <?php }?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label class="label">Owner do Arquivo</label></td>
                        </tr>
                        <tr>
                            <td><input type="text" value="<?php echo $owner ?>" name="T004_owner" class="buscaUsuario" size="100"/></td>
                        </tr>
                        <tr>
                            <td><label class="label">Escolha o Arquivo*</label></td>
                        </tr>
                        <tr>
                            <td><input type="file" name="P0029_arquivo" id="arquivo" class="validate[required] form-input-text" /></td>
                        </tr>
                    </thead>
                </table>
                <div class="form-inpu-botoes">
                    <input type="hidden" name="T004_login" value="<?php echo $user; ?>" />
                    <input type="submit" value="Upload" />
                </div>
            </span>
        </div>
        </form>
    </div>
</div>