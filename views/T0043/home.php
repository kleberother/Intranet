<?php
//Chama classes
$objT043 = new models_T0043();

//Seleciona Lojas
$ListLoja       =   $objT043->listaLojas();

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0043/home" class="active">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="mestre">
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <form action="?router=T0043/js.pdf" method="post" target="_blank" id="formCad">
    <div id="mest-quadrado-left_50">
        <div id="formulario">
            <span class="form-input">
            <table cellspacing="5">
                <tr>
                    <td>
                        <span class="form-titulo">
                            <p>Dados do Cliente</p>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td><label class="label">Nome*    </label></td>
                </tr>
                <tr>
                    <td><input type="text" name="nome" id="nome" class="validate[required] form-input-text-table" /></td>
                </tr>
                <tr>
                    <td><label class="label">CPF*    </label></td>
                </tr>
                <tr>
                    <td><input type="text" name="cpf"     id="cpf" class="validate[required] form-input-text-table" /></td>
                </tr>
                <tr>
                    <td><label class="label">E-mail*    </label></td>
                </tr>
                <tr>
                    <td><input type="text" name="email" id="email" class="validate[required,custom[email]] form-input-text-table" /></td>
                </tr>
                <tr>
                    <td><label class="label">Telefone*    </label></td>
                </tr>
                <tr>
                    <td><input type="text" name="fone" id="fone" class="validate[required] form-input-text-table" /></td>
                </tr>
            </table>
        </span>
        </div>
    </div>
    <div id="mest-quadrado-right_50">
        <div id="formulario">
            <span class="form-input">
                <table cellspacing="5">
                    <tr>
                        <td>
                            <span class="form-titulo">
                                <p>Dados do Cupom</p>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><label class="label">Data*    </label></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="data" id="data" class="validate[required,custom[date]] form-input-text-table" /></td>
                    </tr>
                    <tr>
                        <td><label class="label">N° Cupom*    </label></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="n_cupom" id="n_cupom" class="validate[required] form-input-text-table" /></td>
                    </tr>
                    <tr>
                        <td><label class="label">ECF*    </label></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="ecf"   id="ecf"   class="validate[required] form-input-text-table" /></td>
                    </tr>
                    <tr>
                        <td><label class="label">Loja*    </label></td>
                    </tr>
                    <tr>
                        <td>
                            <select name="loja" id="loja" class="validate[required] form-input-text-table">
                                <option value="">Selecione...</option>
                            <?php foreach($ListLoja as $campos=>$valores){ ?>
                                <option value='<?php echo $valores['LNOME']; ?>'><?php echo ($valores['LNOME']); ?></option>
                            <?php }?>
                            </select>
                        </td>
                    </tr>
                </table>
            </span>
        </div>
    </div>
        <div id="mestre_rodape">
            <div id="formulario">
                <span class="form-input">
                    <div class="form-inpu-botoes">
                        <input type="submit" value="Gerar" />
                    </div>
                </span>
            </div>
        </div>
    </form>
</div>

