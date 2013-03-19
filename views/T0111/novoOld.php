<?php

///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 17/07/2012 por Roberta Schimidt                               
// * Descrição: Ajustes EM$
// * Entrada:   
// * Origens:   
//           
//**************************************************************************

$obj = new models_T0111();

$ListLoja = $obj->listaLojas("0");

$user = $_SESSION['user'];

$data = date('d/m/Y');

if ($_POST["T106_valor_tot"] == "" )
    $_POST["T106_valor_tot2"] = "0.00" ;
if ($_POST["T106_qtd_parc"]== "")
    $_POST["T106_qtd_parc2"] = "0.00";
if ($_POST["T106_valor_par"] == "")
    $_POST["T106_valor_par2"] = "0.00";

$data_inc = date('Y-m-d');

    
if($_POST['T106_cpf']!= "")
{
    
    $campos = array ("T106_data_operacao" => $_POST['T106_data_operacao']
       , "T106_tip_operacao" => $_POST['T106_tip_operacao']
       , "T106_conta" => $_POST['T106_conta']
       , "T106_cpf" => $_POST['T106_cpf']
       , "T106_valor_vista" => $_POST['T106_valor_vista']
       , "T106_qtd_parc" => $_POST['T106_qtd_parc']
       , "T106_valor_par" => $_POST['T106_valor_par']
       , "T106_valor_tot" => $_POST['T106_valor_tot']
       , "T106_n_cupom" => $_POST['T106_n_cupom']
       , "T106_pdv"   => $_POST['T106_pdv']
       , "T106_func_libe" => $_POST['T106_func_libe']
       , "T106_func_lanc" => $_POST['T106_func_lanc'] 
       , "T106_dat_lanc" => $_POST['T106_dat_lanc']
       , "T006_codigo"  => $_POST['T008_T106_loja']
       , "T106_motivo"  => $_POST['T106_motivo']
       , "T106_justificativa" => $_POST['T106_justificativa']
       , "T106_instrucoes" => $_POST['T106_instrucoes']
       , "T106_status" => "0"
        );
    
    
    
    $tabela = "T106_ajustes_ems";
    
 $insere = $obj->inserir($tabela, $campos);
 
header('location:?router=T0111/home');
 
} elseif (!is_null($_POST['T106_cpf2'])){
    
    $campos = array ("T106_data_operacao" => $_POST['T106_data_operacao2']
       , "T106_tip_operacao" => $_POST['T106_tip_operacao2']
       , "T106_conta" => $_POST['T106_conta2']
       , "T106_cpf" => $_POST['T106_cpf2']
       , "T106_valor_vista" => $_POST['T106_valor_vista2']
       , "T106_qtd_parc" => $_POST['T106_qtd_parc2']
       , "T106_valor_par" => $_POST['T106_valor_par2']
       , "T106_valor_tot" => $_POST['T106_valor_tot2']
       , "T106_n_cupom" => $_POST['T106_n_cupom2']
       , "T106_pdv"   => $_POST['T106_pdv2']
       , "T106_func_libe" => $_POST['T106_func_libe2']
       , "T106_func_lanc" => $_POST['T106_func_lanc'] 
       , "T106_dat_lanc" => $_POST['T106_dat_lanc']
       , "T006_codigo"  => $_POST['T008_T106_loja2']
       , "T106_motivo"  => $_POST['T106_motivo']
       , "T106_justificativa" => $_POST['T106_justificativa']
       , "T106_instrucoes" => $_POST['T106_instrucoes']
       , "T106_status" => "0"

        );
    
    $tabela = "T106_ajustes_ems";
    
 $insere = $obj->inserir($tabela, $campos);
 
 
header('location:?router=T0111/home');
    
    
}
    
    

?>



<script src="template/js/interno/T0111/novo.js"></script>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0111/home">Listar</a></li>
                <li><a href="?router=T0111/novo" class="active">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<form action="" method="post" id="formCad">
<div id="formulario" class="formulario">
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-titulo">
        <p>Dados do Ajuste</p>
    </span>
    <span class="form-input">
          <div id="form-trocar">
          <a href="#" onClick="alternarForm('parcelado')">Ajuste no Parcelado</a>
            <a href="#" onClick="alternarForm('avista')" >Ajuste à Vista </a>
        </div>
         <!-- PARCELADO - INICIO -->
        <table style="display: block;" id="parcelado">
            <tr>
                <td><label class="label">Data da Operação *  </label></td>
                <td><label class="label">Tipo da Operação *  </label></td>
                <td><label class="label">Conta (Nº do Cartão) *             </label></td>
                <td><label class="label">CPF do Cliente *</label></td>
            </tr>
            <tr>
                <td>            <input type="text" name="T106_data_operacao"  id="dat_ope" class="validate[required] data"     /></td>
                <td>            <select name="T106_tip_operacao"     id="tipo_oper" class=" validate[required] form-input-text-table">
                                    <option value ="0">Tipo da Operação...</option>
                                    <option value ="INCP">INCP</option>
                                    <option value ="ESCP">ESCP</option></select>
                <td>            <input type="text" name="T106_conta"  id="conta"                class="validate[required] form-input-text-table" /></td>
                <td>            <input type="text" name="T106_cpf"  id="cpf" class="validate[required] cpf"       /></td>
            </tr>
            <tr>
                <td>            <label class="label">Valor a Vista *</label></td>
                <td>            <label class="label">Quantidade de Parcelas *</label></td>
                <td>            <label class="label">Valor da Parcela *</label></td>
                <td>            <label class="label">Valor Total Financiado</label></td>
            </tr>
            <tr>
                <td> <input type="text" name="T106_valor_vista"         id="val_vis"     class="validate[required] valor" /></td>
                <td> <input type="text" name="T106_qtd_parc"         id="quantidade"         class=" validate[required] form-input-text-table" /></td>
                <td> <input type="text" name="T106_valor_par"         id="preco"    onChange="soma()"     class="validate[required]  valor" /></td>
                <td> <input type="text" name="T106_valor_tot"         id="total"         class=""  readonly/></td>
            </tr>
            <tr>
                <td>            <label class="label">Loja *</label></td>
                <td>            <label class="label">PDV</label></td>
                <td>            <label class="label">Nº do Cupom</label></td>
                <td>            <label class="label">Ajuste Liberado por</label></td>
            </tr>
            <tr>
                <td>      <select name="T008_T106_loja" id="loja" class="validate[required] form-input-text-table loja">
                        <option value="">Selecione...</option>
                    <?php foreach($ListLoja as $campos=>$valores){ ?>
                        <option value='<?php echo $valores['LCODI']; ?>'><?php echo ($valores['LNOME']); ?></option>
                    <?php }?>
                    </select></td>
                <td> <input type="text" name="T106_pdv"         id="PDV"         class="form-input-text-table" /></td>
                <td> <input type="text" name="T106_n_cupom"         id="n_cupom"         class="form-input-text-table" /></td>
                <td> <input type="text" name="T106_func_libe"         id="lib_por"         class="form-input-text-table" /></td>
            </tr>
        </table>
        <!-- PARCELADO -  FIM -->
        <!-- A vista - inicio -->
        <table style="display: none;" id="avista">
            <?php $ListLoja = $obj->listaLojas(); ?>
            <tr>
                <td><label class="label">Data da Operação *  </label></td>
                <td><label class="label">Tipo da Operação * </label></td>
                <td><label class="label">Conta (Nº do Cartão) *             </label></td>
                <td><label class="label">CPF do Cliente *</label></td>
            </tr>
            <tr>
                <td>            <input type="text" name="T106_data_operacao2"  id="dat_ope" class="validate[required] data"   /></td>
                <td><select name="T106_tip_operacao2"     id="tipo_oper" class="validate[required] form-input-text-table">
                        <option value ="0">Tipo da Operação...</option>
                        <option value ="INCR">INCR</option>
                        <option value ="ESCR">ESCR</option>
                        <option value ="INEN">INEN</option>
                        <option value ="ESEN">ESEN</option> </select></td>
                <td>            <input type="text" name="T106_conta2"  id="conta"                class="validate[required] form-input-text-table" /></td>
                <td>            <input type="text" name="T106_cpf2"  id="cpf" class="validate[required] cpf"       /></td>
            </tr>
            <tr>
                <td>            <label class="label">Valor a Vista*</label></td>
               
            </tr>
            <tr>
                <td> <input type="text" name="T106_valor_vista2"         id="val_vis"     class="validate[required] valor" /></td>
              
            </tr>
            <tr>
                 <td>            <label class="label">Loja *</label></td>
                 <td>            <label class="label">PDV</label></td>
                 <td>            <label class="label">Nº do Cupom</label></td>
                 <td>            <label class="label">Ajuste Liberado por</label></td>
            </tr>
            <tr>
                <td> <select name="T008_T106_loja2" id="loja" class="validate[required] form-input-text-table loja">
                        <option value="">Selecione...</option>
                    <?php foreach($ListLoja as $campos=>$valores){ ?>
                        <option value='<?php echo $valores['LCODI']; ?>'><?php echo ($valores['LNOME']); ?></option>
                    <?php }?>
                    </select></td> 
                <td> <input type="text" name="T106_pdv2"         id="PDV"         class="form-input-text-table" /></td>
                <td> <input type="text" name="T106_n_cupom2"         id="n_cupom"         class="form-input-text-table" /></td>
                <td> <input type="text" name="T106_func_libe2"         id="lib_por"         class="form-input-text-table" /></td>
            </tr>
            
        </table>
        <!-- A VISTA - FIM -->
       
        <span class="form-titulo">
            <p>Informações / Descrições</p>
        </span>
        
    </span>
</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Motivo</a></li>
        <li><a href="#tabs-2">Justificativas</a></li>
        <li><a href="#tabs-3">Instruções</a></li>
    </ul>
    <div id="tabs-1">
    <span class="form-input">
        <table>
            <tr>
                <td><label class="label">Motivos do ajuste</label></td>
            </tr>
            <tr>
                <td><textarea name="T106_motivo"                id="desc" class="validate[required] textarea-table" cols="" rows="" ></textarea></td>
            </tr>
        </table>
    </span>
    </div>
    <div id="tabs-2">
    <span class="form-input">
        <table>
            <tr>
                <td><label class="label">Justificativas/Considerações relevantes:</label></td>
            </tr>
            <tr>
                <td><textarea name="T106_justificativa"       id="just" class="vtextarea-table" cols="" rows="" ></textarea></td>
            </tr>
        </table>
    </span>
    </div>
    <div id="tabs-3">
    <span class="form-input">
        <table>
            <tr>
                <td><label class="label">Instruções</label></td>
            </tr>
            <tr>
                <td><textarea name="T106_instrucoes"  id="inst" class="textarea-table" cols="" rows="" ></textarea></td>
            </tr>
        </table>
    </span>
    </div>
   
</div>
<div id="formulario" class="formulario">
    <span class="form-input">
        <div class="form-inpu-botoes">
            <input type="hidden"  name="T106_dat_lanc" value="<?php echo $data; ?>"            />
            <input type="hidden"  name="T106_func_lanc"         value="<?php echo $user;?>"             />
            <input type="submit"                            value="Gravar Ajuste"    id="P0016_btn_criar"/>
        </div>
    </span>
</div>
</form>


    