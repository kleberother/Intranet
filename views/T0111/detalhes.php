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
                    ,"T106_tip_operacao"    =>  $_POST["T106_tip_operacao"]
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
    
 
//header('location:?router=T0111/home');
 
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
                    Sim
                    <?php } else {?>
                    Não
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
                <td>            <?php echo $valores["DataOper"];?>  </td>
                <td>            <?php echo $valores["TipoOper"] ?>
                <td>            <?php echo $valores["Conta"];?>     </td>
                <td>           <?php echo $valores["CPF"];?>        </td>
            </tr>
            <tr>
                <td>            <label class="label">Valor a Vista *</label></td>
                <td>            <label class="label">Quantidade de Parcelas *</label></td>
                <td>            <label class="label">Valor da Parcela *</label></td>
                <td>            <label class="label">Valor Total Financiado</label></td>
            </tr>
            <tr>
                <td>       <?php echo $valores["ValorVista"];?>     </td>
                <td> <?php if ($valores["QtdParc"] != ""){ echo $valores["QtdParc"];} else { echo "0";}?> </td>
                <td> <?php if ($valores["ValorParc"] != "") {echo $valores["ValorParc"];} else {echo "0,00";}?> </td>
                <td> <?php if ($valores["ValorTotal"] != ""){echo $valores["ValorTotal"];} else {echo "0,00";}?> </td>
            </tr>
            <tr>
                <td>            <label class="label">Loja *</label></td>
                <td>            <label class="label">PDV</label></td>
                <td>            <label class="label">Nº do Cupom</label></td>
                <td>            <label class="label">Ajuste Liberado por</label></td>
            </tr>
            <tr>
                <td> <?php $BlistLoja = $obj->retornaLojaFixaSelectBox($valores['CodLoja']);
                        foreach($BlistLoja as $campos2=>$value2){?>
                        <?php echo ($value2['Nome']); ?>
                    <?php }?>
                    </td>
                <td> <?php echo $valores["Pdv"];?>      </td>
                <td> <?php echo $valores["Cupom"];?>    </td>
                <td> <?php echo $valores["FuncLibe"];?> </td>
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
                <td><?php echo $valores["Motivo"];?></td>
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
                <td><?php echo $valores["Justificativa"];?></td>
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
                <td><?php echo $valores["Instrucoes"];?></td>
            </tr>
        </table>
    </span>
    </div>
   
</div>
<div id="formulario" class="formulario">
    <span class="form-input">
        <div class="form-inpu-botoes">
            Data de Lançamento:<br><?php echo $valores["DataLanc"];?> <br>
            Lançado por:<br> <?php echo $valores["Elaborador"];?><br>          
            <input type="hidden"  name="T106_codigo"         value="<?php echo $t106_codigo;?>"             /><br>
             <input type="hidden"  name="EtapaCodigo"         value="<?php echo $valores['EtapaCodigo'];?>"             /><br>
            <input type="hidden"  name="T106_func_conf"         value="<?php echo $user;?>"             /><br>
            <div style="display: none">
                    <p class="parametros">AjusteCodigo:<?php echo $valores['Codigo'];?>;EtapaCodigo:<?php echo $valores['EtapaCodigo'];?></p>
                    </div>
                    
                    
        </div>
    </span>
</div>
</form>
<?php }?>

    