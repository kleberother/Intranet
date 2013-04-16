<?php

///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 17/07/2012 por Roberta Schimidt                               
// * Descrição: Ajustes EM$
// * Entrada:   
// * Origens:   
//           
//**************************************************************************

$conn = "";
$obj = new models_T0111();

// Faz o select de lojas para Select Box
$retornaLojas   =   $obj->retornaLojasSelectBox();




if (!empty($_POST))
{
    
    
    $filtros            =   " ";
    
    $FiltroCpf          =  $_POST['cpf_cli'];
    
    $FiltroLoja         =  $_POST["loja_oper"];
    
    $FiltroDataIni      =  $_POST["dataOper"];
    
    $FiltroDataFim      = $_POST["dataOperFim"];
    
    $FiltroDataInc      =  $_POST["dataInc"];
    
    $FiltroDataIncFim   =  $_POST["dataIncFim"];
    
    $FiltroTipo         =  $_POST["Tipo"];
    
    $FiltroSetor        =  $_POST["Setor"];
    
    $FiltroDataIni = substr($FiltroDataIni,6,4)."-".substr($FiltroDataIni,3,2)."-".substr($FiltroDataIni,0,2);
    $FiltroDataFim = substr($FiltroDataFim,6,4)."-".substr($FiltroDataFim,3,2)."-".substr($FiltroDataFim,0,2);
    $FiltroDataInc = substr($FiltroDataInc,6,4)."-".substr($FiltroDataInc,3,2)."-".substr($FiltroDataInc,0,2);
    $FiltroDataIncFim = substr($FiltroDataIncFim,6,4)."-".substr($FiltroDataIncFim,3,2)."-".substr($FiltroDataIncFim,0,2);
    
    
    if (!empty ($FiltroLoja))
        $filtros    .=  " AND TJ3.T006_codigo = '$FiltroLoja'";
    if (!empty ($FiltroCpf))
        $filtros    .=  " AND TJ3.T106_cpf = '$FiltroCpf'";  
    if ($FiltroDataIni != "--"){
        if($FiltroDataFim != "--"){
         $filtros .= "AND TJ3.T106_data_operacao BETWEEN '$FiltroDataIni' and '$FiltroDataFim'";
        }else {
        $filtros .= "AND TJ3.T106_data_operacao = '$FiltroDataIni'";}}
    if ($FiltroDataInc != "--"){
        if ($FiltroDataIncFim != "--"){
         $filtros .= "AND TJ3.T106_dat_lanc between '$FiltroDataInc' and '$FiltroDataIncFim'";   
        }else{
       $filtros .= "AND TJ3.T106_dat_lanc = '$FiltroDataInc'";}}
    if ($FiltroTipo != "0")
        $filtros .=    "AND TJ7.T107_codigo = '$FiltroTipo'";
    if ($FiltroSetor != "0" && $FiltroSetor == '1')
        $filtros .= "AND TJ3.T004_login in ('colivei','amsilva', 'rsnascim')";
    elseif ($FiltroSetor != "0" && $FiltroSetor == "2")
        $filtros .= "AND TJ3.T004_login not in ('amsilva')";
    
   
      
    
    $status = $_POST["status"];
    
    
        switch ($status) {
        case 1:
            $retornaAjustes   =   $obj->retornaAguardandoMinhaConfirmacao($_SESSION['user'],$filtros);
            break;
        case 2:
            $retornaAjustes   =   $obj->retornaMinhasDigitadas($_SESSION['user'],$filtros);
            break;
        case 3:
            $retornaAjustes   =   $obj->retornaAnteriores($_SESSION['user'],$filtros);
            break;
        case 4:
            $retornaAjustes   =   $obj->retornaPosteriores($_SESSION['user'],$filtros);
            break;
        case 5:
            $retornaAjustes   =   $obj->retornaFinalizadas($_SESSION['user'],$filtros);
            break;
        case 6:
            $retornaAjustes   =   $obj->retornaCanceladas($_SESSION['user'],$filtros);
            break; 
        case 7:
            $retornaAjustes   =  $obj->retornaAguardandoFinalizar($_SESSION['user'], $filtros);
            break;
        case 8:
            $retornaAjustes   =  $obj->retornaAjustesLancados($_SESSION['user'], $filtros);
            break;
        case 9:
            $retornaAjustes   =  $obj->retornaAguardandoLancamento($_SESSION['user'], $filtros);
            break;
    }
}

 
        

        

?>
<script src="template/js/interno/T0111/T0111.js"></script>
<div id="modal">
    <div id="dialog-aprovar" title="Mensagem!" style="display:none">
        <div class='padding-2px-vertical conteudo-visivel'>
            <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja aprovar esse(s) Ajuste(s)?</p>
        </div>
    </div>
</div>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0111/home"  class="active">Listar</a></li>
                <li><a href="?router=T0111/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Ajustes</a></li>
   <?php if ($_SESSION['user'] == "rsnascim" || $_SESSION['user'] == "rrocha" || $_SESSION['user'] == 'kscarpan' ){?>     <li><a href="#tabs-2">Exportar Dados</a></li><?php }?>
    </ul>

 <div id="tabs-1">
        <div id="conteudo">
    <form action="#tabs-1" method="post">
        
                       
         <table class="form-inpu-tab">
            <thead>
                 <tr>
                    <th width="8000px"><label>Status do Ajuste </label></th>
                    <th width="8000px"><label>Setor de Confirmação </label></th>
                    
                        
                    
                </tr>
                <tr>
                    <td>  <select name="status" id="btnStatus">
                    <option value="0" <?php echo $status==0?"selected":""?>>Selecione...                        </option>
                    <option value="1" <?php echo $status==1?"selected":""?>>Aguardando Confirmação              </option>
                    <option value="9" <?php echo $status==9?"selected":""?>>Aguardando Lançamento               </option>
                    <option value="7" <?php echo $status==7?"selected":""?>>Aguardando Finalizar                </option>
                    <option value="8" <?php echo $status==8?"selected":""?>>Ajustes Incluidos                   </option>
                    <option value="2" <?php echo $status==2?"selected":""?>>Meus   Digitados                     </option>
                    <option value="3" <?php echo $status==3?"selected":""?>>Anteriores a Mim                    </option>
                    <option value="4" <?php echo $status==4?"selected":""?>>Posteriores a Mim                   </option>
                    <option value="5" <?php echo $status==5?"selected":""?>>Finalizadas                         </option>
                    <option value="6" <?php echo $status==6?"selected":""?>>Canceladas                          </option>
                </select></td>
                <td>    <select name="Setor">
                            <option value="0">Selecione...      </option>
                            <option value="1">Cobrança          </option>
                            <option value="2">Central           </option>
                        </select></td>
               
                </tr>
                <tr>
                    <th width="1000px"><label>Data da Inclusão </label></th>
                     <th width="1000px"><label>Data da Inclusão Final </label></th>
                    <th width="1000px"><label>Data da Operação </label></th>
                    <th width="1000px"><label>Data da Operação Final </label></th>
                </tr>
                <tr>
                         <td><input  type="text" class="data" name="dataInc"/> </td>
                    <td><input  type="text" class="data" name="dataIncFim"/> </td>
                    <td><input  type="text" class="data" name="dataOper"/> </td>
                    <td><input    type="text" class="data" name="dataOperFim"/> </td>
                </tr>
                <tr>
                    <th width="8000px"><label>CPF do Cliente</label></th>
                    <th width="80000px"><label>Loja</label></th>
                    <th width="8000px"><label>Tipo da Operação </label></th>
                </tr>
                <tr>
                    <td><input type="text" class="cpf" name="cpf_cli"/> </td>
                    <td><select name="loja_oper" id="loja" class="validate[required] form-input-text-table loja">
                        <option value="">Selecione...</option>
                    <?php foreach($retornaLojas as $campos=>$valores){ ?>
                        <option value='<?php echo $valores['Codigo']; ?>'><?php echo ($valores['Nome']); ?></option>
                    <?php }?>
                    </select></td>
                    <td>
                        <select name="Tipo"     id="tipo_oper" class=" validate[required] form-input-text-table">
                            <option value="0">Selecione...</option>
                                    <?php 
                     $SelectBoxTipo   =   $obj->retornaTipoSelectBox(0);
                    foreach($SelectBoxTipo as $campos=>$valoresTipo){ ?>
                                   <option value='<?php echo $valoresTipo['Codigo']; ?>'><?php echo ($valoresTipo['Descricao']); ?></option>
                                    <?php }?> </select>
                    </td>
                   <td>  <input type="submit" id="btnFiltrar" value="Filtrar" onclick="document.getElementById('carregando').style.display='inline'"/>
            </td>
                </tr>
            </thead>
         </table>
        
    </form>
       <span class="lista_itens">  
             <table width="200%" id="dadosAjuste">
		<thead >
			<tr style="background-color: #d3d3d3" >
                            <th width="3%"  style="text-align: center;">Tipo</th>
                            <th width="3%" style="text-align: center;" >Local   </th>
                            <th width="3%" style="text-align: center;" >Data da Operação     </th>
                            <th width="5%" style="text-align: center;"  > PDV    </th>
                            <th width="3%" style="text-align: center;"  > Cupom   </th>
                            <th width="6%" style="text-align: center;">Conta</th>
                            <th width="3%" style="text-align: center;" >Contr </th>
                            <th width="5%" style="text-align: center;" >À vista </th>
                            <th width="3%" style="text-align: center;" > Qtd Parc   </th>
                            <th width="5%" style="text-align: center;"  > Valor da Parcela    </th>
                            <th width="3%" style="text-align: center;"  > Total   </th>
                            <th width="25%" style="text-align: center;"  > Motivo   </th>
                            <th width="12%"  style="text-align: center;">CPF</th>
                            <th width="5%" style="text-align: center;"  >Status   </th>
                            <th width="5%" style="text-align: center;"  > Ações         </th>
                          </tr>
                </thead>
               <tbody >
                   <?php 
                   
              $data = substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
              $dataInc = substr($dataInc,6,4)."-".substr($dataInc,3,2)."-".substr($dataInc,0,2);
                            foreach($retornaAjustes as $campos=>$valores){
                                
                                $dadosUser = $obj->selecionaDadosUser($_SESSION['user']);
                                foreach($dadosUser as $camposUser => $valUser){
                                
                                if($valores["Contratado"] == 0){
                                    $contratado = $valUser["Matricula"];
                                } else {
                                    $contratado = "999";
                                }  }
                                
                                
            $dataRet = $valores["DataOper"];  
            $dataRet = substr($dataRet,8,2)."/".substr($dataRet,5,2)."/".substr($dataRet,0,4);
            $dataIncR = $valores["DataLan"];
            $dataIncR = substr($dataIncR,8,2)."/".substr($dataIncR,5,2)."/".substr($dataIncR,0,4);
            
           $valores["CPF"] = str_replace(".","",$valores["CPF"]);
           $valores["CPF"] = str_replace("-","",$valores["CPF"]);
            
                                $situacao = $obj->retornaStatus($valores["Status"], $valores["Codigo"], $valores["EtapaCodigo"], $status, $valores["Elaborador"], $valores["ProximaEtapa"]);
                                $nLoja = $obj->numeroLoja($valores["CodLoja"]);
                                
                   ?>
                   <tr class="linha_<?php echo $valores["Codigo"];?>">
                       <td><?php echo $valores["TipoOper"];?></td>
                       <td align="center"><?php echo $nLoja;?></td>
                       <td><?php echo $dataRet;?></td>
                       <td><?php echo $valores["Pdv"];?></td>
                       <td><?php echo $valores["Cupom"];?></td>
                       <td><?php echo $valores["Conta"];?></td>
                       <td align="center"><?php echo $contratado;?></td>
                       <td><?php echo str_replace(".", ",",$valores["ValorVista"] );?></td>
                       <td align="center"><?php echo str_replace(".", ",", $valores["QtdParc"]);?></td>
                       <td><?php echo str_replace(".", ",", $valores["ValorParc"]) ;?></td>
                       <td align ="center"><?php echo str_replace(".", ",", $valores["ValorTotal"]) ;?></td>
                       <td ><?php echo $valores["Motivo"];?></td>
                       <td><?php echo $valores["CPF"];?></td>
                       <td><?php echo $situacao; ?></td>
                       <td><ul>
                               <li>
                               <a class="ui-icon ui-icon-search" href="?router=T0111/detalhes&cod=<?php echo $valores["Codigo"]?>"></a>
                               </li>
                               <?php if($valores["Status"]== 0 && $valores["EtapaCodigo"] == 177){?>
                                   <li>
                               <a class="ui-icon ui-icon-check" href="#" onclick="confirmaLinha(<?php echo $valores['Codigo']?>, <?php echo $valores['EtapaCodigo']?>)" title="Confirmar"></a>
                               </li><?php }?>
                               <?php if($_SESSION["user"] == "acfranca" || $_SESSION["user"] == "rsnascim" || $_SESSION["user"] == "kscarpan" || $_SESSION["user"] == "psantos" || $_SESSION["user"] == "cmiranda" || ($_SESSION["user"] == $valores["Elaborador"] && $status == "1" || $status == "2" )) {?>
                                 <li>
                               <a class="ui-icon ui-icon-close" href="#"  onclick="excluirLinha(<?php echo $valores['Codigo']?>)"  title="Excluir"></a>
                               </li>
                               <?php }?>
                               <?php if($_SESSION["user"] == "acfranca" || $_SESSION["user"] == "cmiranda" || $_SESSION["user"] == "rsnascim" || $_SESSION["user"] == "kscarpan" || $_SESSION["user"] == "psantos" ) {?>
                                   <li>
                               <a class="ui-icon ui-icon-pencil" href="?router=T0111/atualizar&cod=<?php echo $valores["Codigo"]?>&EtapaCodigo=<?php echo $valores["EtapaCodigo"]?>&status=<?php echo $status;?>&filtro=<?php echo $filtros;?>" title="Editar"></a>
                               </li>
                                <?php }?>
                               
                           </ul>
               </td>
                       
                   </tr>
               </tbody>
               <?php } ?>
</table></span>     </div>          
  </div>
<?php if ($_SESSION['user'] == "rsnascim" || $_SESSION['user'] == "rrocha" || $_SESSION['user'] == "kscarpan"){?>
    <div id="tabs-2">
        <div id="conteudo">
    <form action="?router=T0111/js.exportarDados" method="POST" target="_blank" >
   
        <table class="form-inpu-tab">
            <thead>
                 <tr>
                    <th width="8000px"><label>Data </label></th>
                    
                </tr>
                <tr>
                    <td>
                       <input  size="9"  type="text" class="data"  name="data" value="<?php echo date("d/m/Y"); ?>" />

                    </td>
                    
                    
                     
                    <td>  <input type="submit" id="btnFiltrar" value="Exportar"/>
            </td>
                </tr>
                        
            </thead>
        </table>
    </form>
         
             
</div>
        
    </div> <?php }?>
</div>  
        
 