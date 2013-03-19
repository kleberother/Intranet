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

$ListLoja = $obj->retornaLojasSelectBox();


$t106_codigo = $_GET['cod'];
$user = $_SESSION['user'];

$data = date('d/m/Y');



$data_inc = date('Y-m-d');




    
if($_POST['T106_cpf']!= "")
{

         if(empty($_POST["T106_st_ajuste"])){
            
            $_POST["T106_st_ajuste"] = '0';
            
        }
  
    $tabela = "T106_ajustes_ems";
    $campos = array( "T106_data_operacao"   =>  $_POST["T106_data_operacao"]
                    ,"T107_codigo"          =>  $_POST["T106_tip_operacao"]
                    ,"T106_conta"           =>  $_POST["T106_conta"]
                    ,"T106_cpf"             =>  $_POST["T106_cpf"]
                    ,"T106_valor_vista"     =>  $_POST["T106_valor_vista"]
                    ,"T106_qtd_parc"        =>  $_POST["T106_qtd_parc"]
                    ,"T106_valor_par"       =>  $_POST["T106_valor_par"]
                    ,"T106_valor_tot"       =>  $_POST["T106_valor_tot"]
                    ,"T106_n_cupom"         =>  $_POST["T106_n_cupom"]
                    ,"T106_pdv"             =>  $_POST["T106_pdv"]
                    ,"T106_func_libe"       =>  $_POST["T106_func_libe"]
                    ,"T004_login"           =>  $_SESSION['user']
                    ,"T106_dat_lanc"        =>  date("d/m/Y")
                    ,"T006_codigo"          =>  $_POST["T006_codigo"]
                    ,"T106_motivo"          =>  $_POST["T106_motivo"]
                    ,"T106_justificativa"   =>  $_POST["T106_justificativa"]  
                    ,"T106_instrucoes"      =>  $_POST["T106_instrucoes"]
                    ,"T106_st_ajuste"       =>  $_POST["T106_st_ajuste"]
                    );
    $delim = "T106_codigo = ".$_POST["T106_codigo"];

    $obj->altera($tabela, $campos, $delim);
    
 
header('location:?router=T0111/home');
 
}
    

$selecionaAjuste = $obj->selecionaAjuste($t106_codigo, $user);

foreach($selecionaAjuste as $campos=>$valores){

    
    $valores["DataOper"] =   substr($valores["DataOper"],8,2)."/".substr($valores["DataOper"],5,2)."/".substr($valores["DataOper"],0,4);
   // $valores["DATA_LAN"] = substr($valores["DATA_LAN"],8,2)."/".substr($valores["DATA_LAN"],5,2)."/".substr($valores["DATA_LAN"],0,4);
    $valores["ValorVista"] = str_replace(".", ",", $valores["ValorVista"]);
    $valores["ValorParc"] = str_replace(".", ",", $valores["ValorParc"]);
    $valores["ValorTotal"] = str_replace(".", ",", $valores["ValorTotal"]);
    
?>



<script src="template/js/interno/T0111/novo.js"></script>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0111/home">Listar</a></li>
                <li><a href="?router=T0111/novo" >Novo</a></li>
                <li><a class="active">Atualizar</a></li>
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
          
         
        <table style="display: block;" id="parcelado">
             <tr>
                <td><label class="label">Finalizadora Ajuste?</label>
                    <?php if($valores["FinAjuste"] == "1") {?>
                    <input type="checkbox" name="T106_st_ajuste" value="1" checked/>
                    <?php } else {?>
                    <input type="checkbox" name="T106_st_ajuste" value="1" />
                    <?php }?>
                </td>
            </tr>
            <tr>
                <td><label class="label">Data da Operação *  </label></td>
                <td><label class="label">Tipo da Operação *  </label></td>
                <td><label class="label">Conta (Nº do Cartão) *             </label></td>
                <td><label class="label">CPF do Cliente *</label></td>
            </tr>
            <tr>
                <td>            <input type="text" name="T106_data_operacao"  id="dat_ope" class="validate[required] data"
                                       value="<?php echo $valores["DataOper"];?>"  /></td>
                <td>            <select name="T106_tip_operacao"     id="tipo_oper" class=" validate[required] form-input-text-table">
                                    <option value ="<?php echo $valores["CodOper"];?>"><?php echo $valores["TipoOper"];?></option>
                                    <?php 
                     $SelectBoxTipo   =   $obj->retornaTipoSelectBox(0);
                    foreach($SelectBoxTipo as $campos=>$valoresTipo){ ?>
                                   <option value='<?php echo $valoresTipo['Codigo']; ?>'><?php echo ($valoresTipo['Descricao']); ?></option>
                                    <?php }?> </select>
                <td>            <input type="text" name="T106_conta"  id="conta"                class="validate[required] form-input-text-table" value ="<?php echo $valores["Conta"];?>"/></td>
                <td>            <input type="text" name="T106_cpf"  id="cpf" class="validate[required] cpf"    value="<?php echo $valores["CPF"];?>"   /></td>
            </tr>
            <tr>
                <td>            <label class="label">Valor a Vista *</label></td>
                <td>            <label class="label">Quantidade de Parcelas *</label></td>
                <td>            <label class="label">Valor da Parcela *</label></td>
                <td>            <label class="label">Valor Total Financiado</label></td>
            </tr>
            <tr>
                <td> <input type="text" name="T106_valor_vista"         id="val_vis"     class="validate[required] valor"
                            value="<?php echo $valores["ValorVista"];?>"/></td>
                <td> <input type="text" name="T106_qtd_parc"         id="quantidade"         class=" validate[required] form-input-text-table" value="<?php if ($valores["QtdParc"] != ""){ echo $valores["QtdParc"];} else { echo "0";}?> " /></td>
                <td> <input type="text" name="T106_valor_par"         id="preco"    onChange="soma()"     class="validate[required]  valor" value="<?php if ($valores["ValorParc"] != "") {echo $valores["ValorParc"];} else {echo "0,00";}?> " /></td>
                <td> <input type="text" name="T106_valor_tot"         id="total"  value="<?php if ($valores["ValorTotal"] != ""){echo $valores["ValorTotal"];} else {echo "0,00";}?> "        class=""  readonly/></td>
            </tr>
            <tr>
                <td>            <label class="label">Loja *</label></td>
                <td>            <label class="label">PDV</label></td>
                <td>            <label class="label">Nº do Cupom</label></td>
                <td>            <label class="label">Ajuste Liberado por</label></td>
            </tr>
            <tr>
                <td>      <select name="T006_codigo" id="loja" class="validate[required] form-input-text-table loja">
                        <?php $BlistLoja = $obj->retornaLojaFixaSelectBox($valores['CodLoja']);
                        foreach($BlistLoja as $campos2=>$value2){?>
                        <option value='<?php echo $value2['Codigo']; ?>'><?php echo ($value2['Nome']); ?></option>
                    <?php }?>
                    <?php foreach($ListLoja as $campos=>$value){ ?>
                        <option value='<?php echo $value['Codigo']; ?>'><?php echo ($value['Nome']); ?></option>
                    <?php }?>
                    </select></td>
                <td> <input type="text" name="T106_pdv"         id="PDV"     value="<?php echo $valores["Pdv"];?> "    class="form-input-text-table" /></td>
                <td> <input type="text" name="T106_n_cupom"         id="n_cupom"  value="<?php echo $valores["Cupom"];?> "       class="form-input-text-table" /></td>
                <td> <input type="text" name="T106_func_libe"         id="lib_por"    value="<?php echo $valores["FuncLibe"];?> "     class="form-input-text-table" /></td>
            </tr>
        </table>
        
        
       
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
                <td><textarea name="T106_motivo"                id="desc" class="validate[required] textarea-table" cols="" rows="" ><?php echo $valores["Motivo"];?></textarea></td>
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
                <td><textarea name="T106_justificativa"       id="just" class="vtextarea-table" cols="" rows="" ><?php echo $valores["Justificativa"];?></textarea></td>
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
                <td><textarea name="T106_instrucoes"  id="inst" class="textarea-table" cols="" rows="" ><?php echo $valores["Instrucoes"];?></textarea></td>
            </tr>
        </table>
    </span>
    </div>
   
</div>
<div id="formulario" class="formulario">
    <span class="form-input">
        <div class="form-inpu-botoes">
            Data de Lançamento:<br><?php //echo $valores["DATA_LAN"];?> <br>
            Lançado por:<br> <?php echo $valores["Elaborador"];?><br>          
            <input type="hidden"  name="T106_codigo"         value="<?php echo $t106_codigo;?>"             /><br>
             <input type="hidden"  name="EtapaCodigo"         value="<?php echo $valores['EtapaCodigo'];?>"             /><br>
            <input type="hidden"  name="T106_func_conf"         value="<?php echo $user;?>"             /><br>
            <div style="display: none">
                    <p class="parametros">AjusteCodigo:<?php echo $valores['Codigo'];?>;EtapaCodigo:<?php echo $valores['EtapaCodigo'];?></p>
                    </div>
                    
                    
            <input type="submit"  value="Atualizar Ajuste"    id="P0016_btn_criar" /> 
            
        </div>
    </span>
</div>
</form>
<?php }?>

    