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

$retornaLojaUsu = $obj->retornaLojas($_SESSION['$user']);

$user = $_SESSION['$user'];
$dataIn = date("d/m/Y");


$SelectBoxLoja   =   $obj->retornaLojasSelectBox();


foreach($retornaLojaUsu as $campos=>$valores)
{
    $codigoLoja     =   $valores['Codigo'];
}


$retornaGrupos  =   $obj->retornaGruposWF($_SESSION['user']);


foreach($retornaGrupos as $campos=>$valores)
{

    $codigoWF   =   $valores['Codigo'];
    
}

if (!empty($_POST))
{
    
    $tabela_106         =       "T106_ajustes_ems";
    
    $tabela_089         =       "T089_parametro_detalhe";
    
    $tabela106060     =       "T106_T060"; 
    

    //Campos para inserir na tabela T106_ajustes_ems
    
    if (!empty($_POST['T106_qtd_parc'])){
        
        if(empty($_POST["T106_st_ajuste"])){
            
            $_POST["T106_st_ajuste"] = '0';
            
        }
        
        if($_POST['T106_tip_operacao'] == "ESCP" ) {
            
            $_POST['T106_valor_tot'] = "-".$_POST['T106_valor_tot'];
        }
        
        if(empty($_POST['T106_pdv'])){
            $_POST['T106_pdv'] = '0';
        }
        
        $lojaIn = $_POST["T006_codigo"];
        
 $camposT106     =       array( "T106_data_operacao"     => $_POST['T106_data_operacao']
                                 , "T107_codigo"      => $_POST['T106_tip_operacao']
                                 , "T106_conta"             => $_POST['T106_conta']
                                 , "T106_status"            => "0"
                                 , "T106_cpf"               => $_POST['T106_cpf']
                                 , "T106_valor_vista"       => $_POST['T106_valor_vista']
                                 , "T106_qtd_parc"          => $_POST['T106_qtd_parc']
                                 , "T106_valor_par"         => $_POST['T106_valor_par']
                                 , "T106_valor_tot"         => $_POST['T106_valor_tot']
                                 , "T106_n_cupom"           => $_POST['T106_n_cupom']
                                 , "T106_pdv"               => $_POST['T106_pdv']
                                 , "T106_func_libe"         => $_POST['T106_func_libe']
                                 , "T004_login    "         => $_SESSION['user']
                                 , "T106_dat_lanc"          => $dataIn
                                 , "T006_codigo"            => $lojaIn
                                 , "T106_motivo"            => $_POST['T106_motivo']    
                                 , "T106_justificativa"     => $_POST['T106_justificativa']
                                 , "T106_instrucoes"        => $_POST['T106_instrucoes']
                                 , "T106_st_ajuste"         => $_POST["T106_st_ajuste"]
                                             
                                    );  
    
   } else {
       
       $lojaIn = $_POST["T006_codigo2"];
       
           if(empty($_POST["T106_st_ajuste2"])){
            
            $_POST["T106_st_ajuste2"] = '0';
            
        }
        
        
     
         if(empty($_POST['T106_pdv2'])){
            $_POST['T106_pdv2'] = '0';
        }
        
       
       
   $camposT106     =       array( "T106_data_operacao"      => $_POST['T106_data_operacao2']
                                 , "T107_codigo"            => $_POST['T106_tip_operacao2']
                                 , "T106_conta"             => $_POST['T106_conta2']
                                 , "T106_status"            => "0"
                                 , "T106_cpf"               => $_POST['T106_cpf2']
                                 , "T106_valor_vista"       => $_POST['T106_valor_vista2']
                                 , "T106_valor_tot"         => $_POST['T106_valor_vista2']
                                 , "T106_n_cupom"           => $_POST['T106_n_cupom2']
                                 , "T106_pdv"               => $_POST['T106_pdv2']
                                 , "T106_func_libe"         => $_POST['T106_func_libe2']
                                 , "T004_login    "         => $_SESSION['user']
                                 , "T106_dat_lanc"          => $dataIn
                                 , "T006_codigo"            => $lojaIn
                                 , "T106_motivo"            => $_POST['T106_motivo']    
                                 , "T106_justificativa"     => $_POST['T106_justificativa']
                                 , "T106_instrucoes"        => $_POST['T106_instrucoes']
                                 , "T106_st_ajuste"         => $_POST["T106_st_ajuste2"]
                                             
                                    );  
                                        
                                        
                                        
                                    }
    
    $insere     = $obj->inserir($tabela_106, $camposT106);
    
    
    $numeroND = $obj->retornaND();
    
    foreach($numeroND as $campos=>$valores){
        
        $codigoND = $valores['codigo'];
        
    }
    
    //Recupera número da etapa para o grupo workflow
    
    
    
    $Etapa = $obj->retornaEtapaGrupo($_POST['T059_codigo']);
    
    foreach($Etapa as $campos=>$valores){
        
        $CamposEtapa = array( "T060_codigo"         => $valores['EtapaCodigo']
                            , "T106_codigo"         => $codigoND
                            , "T006_codigo"         => $lojaIn
                            , "T106_T060_ordem"     => 1
                            , "T106_T060_status"    => 0
                            , "T004_login"          => $_SESSION['user']
                            );
        
        $insereEtapa = $obj->inserir($tabela106060, $CamposEtapa);
        
        $insereFluxo = $obj->InserirFluxo($codigoND, $lojaIn, $valores['ProxEtapaCodigo'], 2, $_SESSION['user']);
        
    }
    
    

    
    
    
    
    
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
    <span class="form-input">
         <div id="form-trocar">
              <a href="#" onClick="alternarForm('avista')" >Ajuste à Vista </a>
              <a href="#" onClick="alternarForm('parcelado')">Ajuste no Parcelado</a>
                    </div>
         <!-- PARCELADO - INICIO -->
        <table style="display: none;" id="parcelado">
            <tr>
                <td><label class="label">Finalizadora Ajuste?</label></td>
                <td><label class="label">Data da Operação *  </label></td>
                <td><label class="label">Tipo da Operação *  </label></td>
                <td><label class="label">CPF do Cliente *</label></td>
                <td><label class="label">Conta (Nº do Cartão) *             </label></td>
                
            </tr>
            <tr>
                 <td><input type="checkbox" name="T106_st_ajuste" value="1"/></td>
                <td>            <input type="text" name="T106_data_operacao"  id="dat_ope" class="validate[required] data"     /></td>
                <td>            <select name="T106_tip_operacao"     id="tipo_oper" class=" validate[required] form-input-text-table">
                                    <option value ="">Tipo da Operação...</option>
                                      <?php 
                     $SelectBoxTipo   =   $obj->retornaTipoSelectBox(1);
                    foreach($SelectBoxTipo as $campos=>$valoresTipo){ ?>
                                   <option value='<?php echo $valoresTipo['Codigo']; ?>'><?php echo ($valoresTipo['Descricao']); ?></option>
                                    <?php }?></select>
                 <td>            <input type="text" name="T106_cpf"       class="cpf"  /></td>
                <td>            <input type="text" name="T106_conta"  id="conta"                class="validate[required] form-input-text-table"  readonly/></td>
               
            </tr>
            <tr>
                <td>            <label class="label">Valor a Vista *</label></td>
                <td>            <label class="label">Quantidade de Parcelas *</label></td>
                <td>            <label class="label">Valor da Parcela *</label></td>
                <td>            <label class="label">Valor Total Financiado</label></td>
            </tr>
            <tr>
                <td> <input type="text" name="T106_valor_vista"       id="val_vis"          class="validate[required] valor" /></td>
                <td> <input type="text" name="T106_qtd_parc"          id="quantidade"     class=" validate[required] form-input-text-table" /></td>
                <td> <input type="text" name="T106_valor_par"         id="preco"         class="validate[required]  valor" /></td>
                <td> <input type="text" name="T106_valor_tot"         id="total"         class=""  readonly/></td>
            </tr>
            <tr>
                <td>            <label class="label">Loja *</label></td>
                <td>            <label class="label">PDV</label></td>
                <td>            <label class="label">Nº do Cupom</label></td>
                <td>            <label class="label">Ajuste Liberado por</label></td>
            </tr>
            <tr>
                <td>      <select name="T006_codigo" id="loja" class="validate[required] form-input-text-table loja">
                        <option value="">Selecione...</option>
                    <?php 
                     $SelectBoxLoja   =   $obj->retornaLojasSelectBox();
                    foreach($SelectBoxLoja as $campos=>$valoresLoja){ ?>
                        <option value='<?php echo $valoresLoja['Codigo']; ?>'><?php echo ($valoresLoja['Nome']); ?></option>
                    <?php }?>
                    </select></td>
                <td> <input type="text" name="T106_pdv"         id="PDV"         class="form-input-text-table" /></td>
                <td> <input type="text" name="T106_n_cupom"         id="n_cupom"         class="form-input-text-table" /></td>
                <td> <input type="text" name="T106_func_libe"         id="lib_por"         class="form-input-text-table" /></td>
            </tr>
        </table>
        <!-- PARCELADO -  FIM -->
        <!-- A vista - inicio -->
        <table style="display: block;" id="avista">
            <tr>
                <td><label class="label">Finalizadora Ajuste?</label></td>
                <td><label class="label">Data da Operação *  </label></td>
                <td><label class="label">Tipo da Operação * </label></td>
                <td><label class="label">CPF do Cliente *</label></td>
                <td><label class="label">Conta (Nº do Cartão) *             </label></td>
                
            </tr>
            <tr>
                 <td><input type="checkbox" name="T106_st_ajuste2" value="1"/></td>
                 <td><input type="text" name="T106_data_operacao2"   class="data"   /></td>
                 <td><select name="T106_tip_operacao2"     id="tipo_oper" class="validate[required] form-input-text-table">
                          <option value ="">Tipo da Operação...</option>
                                      <?php 
                     $SelectBoxTipo   =   $obj->retornaTipoSelectBox(2);
                    foreach($SelectBoxTipo as $campos=>$valoresTipo){ ?>
                                   <option value='<?php echo $valoresTipo['Codigo']; ?>'><?php echo ($valoresTipo['Descricao']); ?></option>
                                    <?php }?></select>
               <td>            <input type="text" name="T106_cpf2"  id="cpf" class="cpf"   /></td>
                 <td>            <input type="text" name="T106_conta2"  id="conta"                class="validate[required] form-input-text-table" readonly /></td>
                
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
                <td> <select name="T006_codigo2" id="loja" class="validate[required] form-input-text-table loja">
                        <option value="">Selecione...</option>
                    <?php 
                    $SelectBoxLoja   =   $obj->retornaLojasSelectBox();
                    foreach($SelectBoxLoja as $campos=>$valoresLoja2){ ?>
                        <option value='<?php echo $valoresLoja2['Codigo']; ?>'><?php echo ($valoresLoja2['Nome']); ?></option>
                    <?php }?>
                    </select></td> 
                <td> <input type="text" name="T106_pdv2"         id="PDV"         class="form-input-text-table" /></td>
                <td> <input type="text" name="T106_n_cupom2"         id="n_cupom"         class="form-input-text-table" /></td>
                <td> <input type="text" name="T106_func_libe2"         id="lib_por"         class="form-input-text-table" /></td>
            </tr>
            
        </table>
        <!-- A VISTA - FIM -->
       
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
            <?php $data_inc = date('Y-m-d');?>
            <input type="hidden"  name="T106_dat_lanc" value="<?php echo $data_inc; ?>"            />
            <input type="hidden"  name="T004_login"         value="<?php echo $user;?>"             />
             <input  type="hidden"  name="T059_codigo"       value="<?php echo $codigoWF; ?>"       />
            <input type="submit"                            value="Gravar Ajuste"    id="P0016_btn_criar"/>
        </div>
    </span>
</div>
</form>


    