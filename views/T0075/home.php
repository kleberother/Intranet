<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 16/01/2012 por Roberta Schimidt                               
 * Descrição: Tela totais Cartão
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/
$user       = $_SESSION['user'];




// Instancia Classe T0075 para conexao Emporium
$connEMP            =  "emporium"                                   ;               
$verificaConexao    =  1                                            ; //se 1 ignora conexao, caso haja erro na conexao com BD do Emporium
$objEMP             =  new models_T0075($connEMP,$verificaConexao)  ;

    $conn             =   "mssql";
    $verificaConexao    =   "";
    $db                 =   "DBO_CRE";
    $objMSSQL = new models_T0075($conn,$verificaConexao,$db);

$conn = "";
$obj = new models_T0075($conn);

$usuarioConfianca = $obj->retornaPerfilConfianca($user);

foreach ($usuarioConfianca as $keyUser => $valueUser) 
    {
    $loginUserC = $valueUser["usuario"];
    }
    
    

?>




<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0075/home" class="active">Totais</a></li>
                
                 
                
            </ul>
        </span>
    </div>
</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Pagamentos</a></li>
        <li><a href="#tabs-2">Vendas</a></li>
        <li><a href="#tabs-3">Relatório de Totais</a></li> 
       

   </ul>
    <div id="tabs-1">
        <div id="conteudo">
    <form action="#tabs-1" method="post">
        <?php 
// indica o tipo de totais consultado 1 = pagamentos e 2 = vendas
$totais = "1";
$dataini = $_POST['DataInicial'];
$dataini = substr($dataini,6,4)."-".substr($dataini,3,2)."-".substr($dataini,0,2);
$datafim = $_POST['DataFinal'];
$datafim = substr($datafim,6,4)."-".substr($datafim,3,2)."-".substr($datafim,0,2);
$tipBusca = $_POST['TipBusca'];
$lojaIn = $_POST['loja'];

$statusLoja = $_POST["loja"];
    
$mes    = date("m");
$ano    = date("Y");          

         $datainiShow = substr($dataini,8,2)."/".substr($dataini,5,2)."/".substr($dataini,0,4);
        $datafimShow = substr($datafim,8,2)."/".substr($datafim,5,2)."/".substr($datafim,0,4);
        

?>  
        <table class="form-inpu-tab">
            <thead>
                 <tr>
                    <th width="8000px"><label>Data </label></th>
                    <th width="8000px"><label>Buscar</label></th>
                    <th width="80000px"><label>Loja</label></th>
                </tr>
        
                    <td>
                       <input  size="9"  type="text" class="data"  name="DataInicial" value="<?php if ($dataini == "--") {echo date("d/m/Y");} else {echo $datainiShow;} ?>" />

                    </td>
                    
                    <td>
                        <select id="aps" name="TipBusca" >
                            <?php $buscaTip = $obj->retornaBuscaCombo($tipBusca);
                            echo $buscaTip;?>
                        </select>
                    </td>   
                    
                    <td>
                        <select  name="loja" >
                         <?php 
                         $nLojaPag = $objMSSQL->retornaNomeLojaPag($lojaIn); 
                        $BuscaLojaPag = $obj->retornaBuscaComboLoja($lojaIn);
                        echo $BuscaLojaPag;
                         ?>
                        <?php 
                             //}
//retorna valores do combobox Loja
$comboPag = $obj->retornaComboPag();

foreach ($comboPag as $keyComboPag => $valueComboPag)
{   
    //retorna nome das lojas
    $nLojaPag = $objMSSQL->retornaNomeLojaPag($valueComboPag['T006_codigo']);
    
?>
<option value="<?php echo $nLojaPag?>">  <?php echo $nLojaPag." - ".$valueComboPag['T006_nome'];?> </option>
                            
                         
    <?php }?></select>
                        
                    </td>
                     
                    <td>  <input type="submit" id="btnFiltrar" value="Filtrar" onclick="document.getElementById('carregando').style.display='inline'"/>
            </td>
                </tr>
                        
            </thead>
        </table>
    </form>
            
             <div id="carregando" style="display: none;"> Carregando aguarde... </div>
</div>
        <div id="conteudo" >
    <span class="lista_itens">      
        
        
        <?php
      
            
                    $Udia = substr($datafim,8,2);
                 
                 if(($lojaIn == "") or ($lojaIn == "0")){
                     
                    echo "Selecione a loja ...";
                     
                 }else{ 
   ?>
        
        
	<table width="80%">
		<thead >
			<tr style="background-color: #d3d3d3" >
                           <th width="5%" style="text-align: center;" >LOJA     </th>
                            <th width="10%" style="text-align: center;">PDV</th>
                            <th width="5%"  style="text-align: center;" colspan="4">Emporium</th>
                            <th width="5%"  style="text-align: center;" colspan="4">EMS</th>
                            <th width="5%" style="text-align: center;" >Diferença     </th>
                            <th width="5%" style="text-align: center;" >     </th>
                            <th width="5%" style="text-align: center;" colspan ="3" >     </th>
                          </tr>
                      
               	
		</thead>
                <thead >
			<tr style="background-color: #d3d3d3" >
                           <th width="5%" style="text-align: center;" >     </th>
                            <th width="10%" style="text-align: center;"></th>
                             <th width="5%"  style="text-align: center;" >Qtd</th>
                            <th width="5%"  style="text-align: center;" >Valor</th>
                              <th width="5%"  style="text-align: center;" >Qtd Estorno</th>
                            <th width="5%"  style="text-align: center;" >Estorno</th>
                            <th width="5%"  style="text-align: center;" >Qtd</th>
                            <th width="5%"  style="text-align: center;" >Valor</th>
                            <th width="5%"  style="text-align: center;" >Qtd Cancelamento</th>
                            <th width="5%"  style="text-align: center;" >Cancelamento</th>
                         
                            <th width="5%" style="text-align: center;" >     </th>
                            <th width="1%" style="text-align: center;" >Listar</th>
                             <th width="5%" style="text-align: center;" colspan="3" >Ajustes/Obs</th>
                          </tr>
                      
               	
		</thead>
                <tbody >
                     <?php
                    
                     $sPagQtdEmp = 0;
                     $sPagValEmp = 0;
                     $sPagEstEmp = 0;
                     $sPagQtdEstEmp = 0;
                     $sPagQtdEms = 0;
                     $sPagValEms = 0;
                     $sPagQtdCanEms = 0;
                     $sPagValCanEms = 0;
                     $sPagDif = 0;
                     $sPagObs = 0;
                     
                     
               $objMSSQL->inserirDadosTempPag($dataini); 
                    
      $pagamentoEmporium = $objEMP->retornaPagEmporium($dataini, $dataini, $lojaIn);
                   
                    foreach($pagamentoEmporium as $campos=>$valores){
                           
                           $lojaEmp = $valores["store_key"];
                           $pdvEmp = $valores["pos_number"];
                           $valorEmp = $valores["ValorEmp"];
                           $qtdPagEmp = $valores["QtdEmp"];
                           
                        $valorEmp = substr($valorEmp, 0, -1);
                        $valorEmp = str_replace(".", ",", $valorEmp);
                        
                           
                         $lojaEmp = $obj->formataNumero($lojaEmp);
                         $pdvEmp = $obj->formataNumero($pdvEmp);
                         
                         $estornoPag = $objEMP->retornaEstornoEmp($pdvEmp, $lojaEmp, $dataini);
                         
                         foreach($estornoPag as $key=>$value){
                             
                             $valorEst = $value["amount"];
                             $valorEst = substr($valorEst, 0, -1);
                             $valorEst = str_replace(".", ",", $valorEst);
                             
                             $qtdEst = $value["quantity"];
                             $pdvEst = $value["pos_number"];
                             $lojaEst = $value["store_key"];
                         
                         }
                         
                         $pagamentoEms = $objMSSQL->retornaPagEMS($dataini, $dataini, $lojaEmp, $pdvEmp);
                         
                         $resEMS = mssql_fetch_array($pagamentoEms);
                         
                         $valorEms = $resEMS["VALOR_PAG"];
                         $valorEms = number_format($valorEms, 2, ",", "");
                         $qtdEms = $resEMS["QTD_PAG"];
                         $valorCancelEms = $resEms["VALOR_CAN"];
                         $valorCancelEms = number_format($valorCancelEms, 2, ",", "");
                         $qtdCancelEms = $resEms["QTD_CAN"];
                         
                         //calcula valor liquido Emporium
                         
                         if(($pdvEmp == $pdvEst) and ($lojaEmp == $lojaEst)){
                         
                         $valorEmp = $obj->formataReais($valorEmp, $valorEst, "-");
                         $valorEmp = $obj->totalValores($valorEmp);
                         } // fim do calculo de estorno
                         
                         //retorna observação
                         
                         $retornaObs= $obj->retornaObs($pdvEmp, $lojaEmp, "0", $dataini);
                         
                         foreach($retornaObs as $obsKey => $obsValue);
                             
                             $pdvObs = $obsValue["T090_pdv"];
                             $lojaObs = $obsValue["T090_loja"];
                             $valorObs = $obsValue["T090_valor"];
                             $tipoOperacao = $obsValue["T090_tipo_op"];
                             
                             
                         
                         

                         
                         
                         $valorObs = $obj->totalValores($valorObs);
                         
                   //calcula diferença
                         
                         $diferencaPag = $obj->formataReais($valorEms, $valorEmp, "-");
                         $diferencaPag = $obj->totalValores($diferencaPag);
                         
                              if (($pdvEmp == $pdvObs) and ($lojaEmp == $lojaObs)){
                             if($tipoOperacao == '2'){
                             $diferencaPag = $obj->formataReais($diferencaPag, $valorObs, "+");
                             } else {
                                 $diferencaPag = $obj->formataReais($diferencaPag, $valorObs, "-");
                             }
                             $diferencaPag = $obj->totalValores($diferencaPag);
                             
                         } else {
                         
                         
                         $diferencaPag = $obj->formataReais($valorEms, $valorEmp, "-");
                         $diferencaPag = $obj->totalValores($diferencaPag);
                         
                         
                         }
                         //cor do fundo
                         $corfundo = $obj->corfundo($diferencaPag, "$qtdCancelEms");
                         
                        
                         
                        
                         
                  
                         if($tipBusca == "1"){
                             if($diferencaPag != ""){
                       
                                
                     ?>
                    <tr >
                            <td width="5%" style="text-align: center; background-color: <?php echo $corfundo;?>;" > <?php echo $lojaEmp;?>    </td>
                            <td width="10%" style="text-align: center; background-color: <?php echo $corfundo;?>;"><?php echo $pdvEmp;?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $qtdPagEmp;?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $valorEmp; ?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php if (($lojaEmp == $lojaEst)and ($pdvEst == $pdvEmp)){echo $qtdEst;}?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php if (($lojaEmp == $lojaEst)and ($pdvEst == $pdvEmp)){  echo $valorEst;}?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $qtdEms;?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $valorEms;?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $qtdCancelEms;?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $valorCancelEms?></td>
                         
                            <td width="5%" style="text-align: center; background-color: <?php echo $corfundo;?>;" > <?php echo $diferencaPag;?>    </td>
             <td width="1%" style="text-align: center; background-color:<?php echo $corfundo;?>;"><a target="_blank" class="ui-icon ui-icon-note" href="?router=T0075/listapdvpag&DataInicial=<?php echo $dataini;?>&DataFinal=<?php echo $dataini;?>&loja=<?php echo $lojaEmp;?>&pdv=<?php echo $pdvEmp;?>" title="Listar PDV"></a>                    </td>
                             <td width="5%" style="text-align: center;  background-color:<?php echo $corfundo;?>;"><?php if ($loginUserC != ""){ ?><a target="_blank" class="ui-icon ui-icon-info" href="?router=T0075/observacoes&data=<?php echo $dataini;?>&loja=<?php echo $lojaEmp;?>&pdv=<?php echo $pdvEmp;?>&final=<?php echo "0";?>"    onmouseover ='show_tooltip_alert("","Clique aqui para adicionar uma Observação", true);'></a><?php }?></td>
   
                                <td width="1%" style="background-color:<?php echo $corfundo;?>;">  <?php if(($pdvEmp  == $pdvObs ) and ($lojaEmp == $lojaObs)){?><a class="ui-icon ui-icon-check"></a> <?php }?> </td>  
                                   <td width="5%" style="text-align: center; background-color: <?php echo $corfundo;?>;" > <?php echo $valorObs;  $valorObs = str_replace(",", "", $valorObs);
                     $sPagObs += $valorObs;?></td>
                          </tr>
                    
                         
                    <?php
                    
                             
                     $valorEmp = str_replace(",", "", $valorEmp);
                     $sPagValEmp += $valorEmp;
                     $sPagQtdEmp += $qtdPagEmp;
                     $valorEst = str_replace(",", "", $valorEst);
                     $sPagEstEmp += $valorEst;
                     $sPagQtdEstEmp += $qtdEst;
                     $sPagQtdEms += $qtdEms;
                     $valorEms = str_replace(",", "", $valorEms);
                     $sPagValEms += $valorEms;
                     $sPagQtdCanEms += $qtdCancelEms;
                     $valorCancelEms = str_replace(",", "", $valorCancelEms);
                     $sPagValCanEms += $valorCancelEms;
                     $diferencaPag = str_replace(",", "", $diferencaPag);
                     $sPagDif += $diferencaPag;
                    
                    
                    
                    }} else {  ?>
                    
                    	<tr >
                            <td width="5%" style="text-align: center; background-color: <?php echo $corfundo;?>;" > <?php echo $lojaEmp;?>    </td>
                            <td width="10%" style="text-align: center; background-color: <?php echo $corfundo;?>;"><?php echo $pdvEmp;?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $qtdPagEmp;?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $valorEmp;?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php if (($lojaEmp == $lojaEst)and ($pdvEst == $pdvEmp)){echo $qtdEst;}?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php if (($lojaEmp == $lojaEst)and ($pdvEst == $pdvEmp)){  echo $valorEst;}?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $qtdEms;?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $valorEms;?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $qtdCancelEms;?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $valorCancelEms?></td>
                         
                            <td width="5%" style="text-align: center; background-color: <?php echo $corfundo;?>;" > <?php echo $diferencaPag;?>    </td>
                           <td width="1%" style="text-align: center; background-color:<?php echo $corfundo;?>;"><a target="_blank" class="ui-icon ui-icon-note" href="?router=T0075/listapdvpag&DataInicial=<?php echo $dataini;?>&DataFinal=<?php echo $dataini;?>&loja=<?php echo $lojaEmp;?>&pdv=<?php echo $pdvEmp;?>" title="Listar PDV"></a>                    </td>
                                         <td width="5%" style="text-align: center;  background-color:<?php echo $corfundo;?>;"><?php if($loginUserC !=""){?><a target="_blank" class="ui-icon ui-icon-info" href="?router=T0075/observacoes&data=<?php echo $dataini;?>&loja=<?php echo $lojaEmp;?>&pdv=<?php echo $pdvEmp;?>&final=<?php echo "0";?>" onmouseover ='show_tooltip_alert("","Clique aqui para adicionar uma Observação", true);'></a><?php }?></td>
   
                                <td width="1%" style="background-color:<?php echo $corfundo;?>;">  <?php if(($pdvEmp  == $pdvObs ) and ($lojaEmp == $lojaObs)){?><a class="ui-icon ui-icon-check"></a> <?php }?> </td>  
                                   <td width="5%" style="text-align: center; background-color: <?php echo $corfundo;?>;" > <?php if(($pdvEmp  == $pdvObs ) and ($lojaEmp == $lojaObs)){echo $valorObs;    $valorObs = str_replace(",", "", $valorObs);
                     $sPagObs += $valorObs;
                      }?></td>
                          </tr>
                    
                    
                    
                    <?php
                    
                     $valorEmp = str_replace(",", "", $valorEmp);
                     $sPagValEmp += $valorEmp;
                     $sPagQtdEmp += $qtdPagEmp;
                     $valorEst = str_replace(",", "", $valorEst);
                     $sPagEstEmp += $valorEst;
                     $sPagQtdEstEmp += $qtdEst;
                     $sPagQtdEms += $qtdEms;
                     $valorEms = str_replace(",", "", $valorEms);
                     $sPagValEms += $valorEms;
                     $sPagQtdCanEms += $qtdCancelEms;
                     $valorCancelEms = str_replace(",", "", $valorCancelEms);
                     $sPagValCanEms += $valorCancelEms;
                     $diferencaPag = str_replace(",", "", $diferencaPag);
                     $sPagDif += $diferencaPag;
                  
                     
                    }
                              } 
            ?>
                          <tr style="background-color: #d3d3d3" align="center">
                              <td>
                                  <b>TOTAL:</b>
                              </td>
                              <td></td>
                              <td align="center">
                                  <?php echo $sPagQtdEmp;?>
                              </td>
                              <td>
                                  <?php echo $obj->totalValores($sPagValEmp); ?>
                              </td>
                              <td align = "center">
                                  <?php echo $sPagQtdEstEmp;?>
                              </td>
                              <td>
                                  <?php echo $obj->totalValores($sPagEstEmp);?>
                              </td>
                              <td align="center">
                                  <?php echo $sPagQtdEms;?>
                              </td>
                              <td>
                                  <?php echo $obj->totalValores($sPagValEms);?>
                              </td>
                              <td align ="center">
                                 <?php echo $sPagQtdCanEms;?>
                              </td>
                              <td align ="center">
                                  <?php echo $obj->totalValores($sPagValCanEms);?>
                              </td>
                              <td>
                                  <?php echo $obj->totalValores($sPagDif);?>
                              </td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td>
                                 <?php echo $obj->totalValores($sPagObs);?>
                              </td>
                          </tr>
                </tbody>
        </table>
    </span><?php }?>
     

</div>
    </div>
    
    <div id="tabs-2">
        <div id="conteudo">
        <?php 
       $dataVenda = $_POST["dataVenda"];
       $dataVenda = substr($dataVenda, 6,4)."-".substr($dataVenda, 3,2)."-".substr($dataVenda,0,2);
       $lojaInVenda = $_POST["lojaVenda"];
       $tipBusca2 = $_POST["tipBusca"];
       $venda = $_POST["tipVenda"];
       $dataVendaView = substr($dataVenda, 8,2)."/".substr($dataVenda,5,2)."/".substr($dataVenda,0,4);
       
       
       ?>
            <form action="#tabs-2" method="POST" >
                
                <script language="Javascript">
                        function mostrar()
                        {
                        document.form.recipient.value = "1";
                        document.form.submit();
                        document.getElementById('carregando2').style.display='inline';
                        }
                </script>
                
                
                <table class="form-input-tab">
                      <thead>
                 <tr>
                    <th    style="text-align: center;" ><label>Data</label></th>
                    <th width="800px"  style="text-align: center;" ><label>Finalizadora</label></th>
                    <th width="800px" style="text-align: center;" ><label>Buscar</label></th>
                    <th width="1000px"  style="text-align: center;" ><label>Loja</label></th>
                    <th   style="text-align: center;" ><label></label></th>
                </tr>  
                      <tr>
                    <td  style="text-align: center;">
                       <input  size="9"  type="text" class="data"  name="dataVenda" value="<?php if ($dataVenda == "--") {echo date("d/m/Y");} else {echo $dataVendaView;} ?>" />

                    </td>
                    <td  style="text-align: center;">
                        <select id="aps" name="tipVenda" >
                            <?php $finalizadoras = $obj->retornaFinalizadoras($venda);
                            echo $finalizadoras;
                            ?>
                        </select>
                    </td>
                    
                   <td  style="text-align: center;">
                        <select id="aps" name="tipBusca" >
                        <?php $buscaTip2 =  $obj->retornaBuscaCombo($tipBusca2);
                        echo $buscaTip2;?>  
                        </select>
                    </td>
                       
                      <td  style="text-align: center;">
                        <select  name="lojaVenda" >
                            <?php $nLojaVenda = $objMSSQL->retornaNomeLojaPag($lojaInVenda); 
                            $BuscaLojaVenda = $obj->retornaBuscaComboLoja($lojaInVenda);
                        echo $BuscaLojaVenda;
                         ?>   
                            <?php 
                           
                            //retorna valores do combobox Loja
                            $comboVenda = $obj->retornaComboVend();
                            

                            foreach($comboVenda as $keyComboVenda => $valueComboVenda)
                            {
                                
                               //retorna nome das lojas
                                $nLojaVenda = $obj->retornaNomeLojaVend($valueComboVenda["T006_codigo"]);    ?>
              <option value="<?php echo $nLojaVenda;?>">  <?php echo $nLojaVenda." - ".$valueComboVenda["T006_nome"];?> </option>
                            
                 <?php } if ($lojaInVenda != ""){?>
              <option value="0">    Todas     </option> <?php }?>
                        </select>
                        
                    </td>
                          
                    <td  style="text-align: center;">  <input type="submit" id="btnFiltrar" value="Filtrar" onclick="document.getElementById('carregando2').style.display='inline'"/>
            </td>
                </tr>
                    </thead>
                </table>
            </form>
        <?php if (($venda == "") or ($venda == '0')) { echo "<br>Selecione uma finalizadora..."; } else {?>
            <div id="carregando2" style="display: none;"> Carregando aguarde... </div>
            
              
    <span class="lista_itens">
        
       <?php if ($dataVenda != "--"){  ;?> 
        <table width="80%">
		<thead >
			<tr style="background-color: #d3d3d3" >
                            <th width="5%" style="text-align: center;" >LOJA     </th>
                            <th width="5%" style="text-align: center;">PDV</th>
                            <th width="5%"  style="text-align: center;" colspan="4">Emporium</th>
                            <th width=  "5%"  style="text-align: center;" colspan="4">EMS</th>
                            <th width="5%" style="text-align: center;" >     </th>
                            <th width="5%" style="text-align: center;" >     </th>
                            <th width="5%" style="text-align: center;" colspan="4" >     </th>
                          </tr>
                      
               	
		</thead>
                
                	<thead >
			
                      	<tr style="background-color: #d3d3d3" >
                           <th width="5%" style="text-align: center;" >     </th>
                            <th width="5%" style="text-align: center;"></th>
                             <th width="5%"  style="text-align: center;" >Qtd</th>
                            <th width="5%"  style="text-align: center;" >Valor</th>
                             <th width="5%"  style="text-align: center;" >Qtd Cancel</th>
                            <th width="5%"  style="text-align: center;" >Valor Cancel</th>
                            <th width="5%"  style="text-align: center;" >Qtd</th>
                            <th width="5%"  style="text-align: center;" >Valor</th>
                              <th width="5%"  style="text-align: center;" >Qtd Cancel</th>
                            <th width="5%"  style="text-align: center;" >Valor Cancel</th>
                            <th width="5%" style="text-align: center;" >Diferença</th>
                            <th width="5%" style="text-align: center; " >Listar</th>
                            <th width="5%" style="text-align: center; " >Ajustes</th>
                            <th width="5%" style="text-align: center; " >Inclusões</th>
                            <th width="5%" style="text-align: center; "  >Estornos</th>
                          </tr>
               	
		</thead>
                <tbody >
        
                    
        <?php 
        
        $sVendaValEmp = 0;
        $sVendaQtdEmp = 0;
        $sVendaValCanEmp = 0;
        $sVendaQtdCanEmp = 0;
        $sVendaValEms = 0;
        $sVendaQtdEms = 0;
        $sVendaQtdCanEms = 0;
        $sVendaValCanEms = 0;
        $sDifVenda = 0;
        $sObsVenda = 0;
        
        $vendaEmp = $objEMP->retornaVendaEmporium($dataVenda, $venda, $lojaInVenda);
            foreach($vendaEmp as $keyVenda => $valueVenda){
            
            
            $pdvVendaEmp = $valueVenda["pdv"];
            $lojaVendaEmp = $valueVenda["loja"];
            $qtdVendaEmp = $valueVenda["qtd"];
            $valorVendaEmp = $valueVenda["valor"];
            $valorCanVendaEmp = $valueVenda["valorCan"];
            $qtdCanVendaEmp = $valueVenda["qtdCan"];
           
                    
               
            
            $ajustesEms  = $obj->retornaSomaTotalAjuste($dataVenda, $lojaInVenda, $pdvVendaEmp, $venda);
                foreach($ajustesEms as $keyAjuste => $valueAjuste);
                         
                
                $lj = $obj->editaLoja($valueAjuste["loja"]);
           
                
            
 
            

            
            if ($venda == "2"){
                
              
                
                if($valorCanVendaEmp != '0.000'){
                    
$valorCanVendaEmp = str_replace(".", "", $valorCanVendaEmp);
$realVendaCan = substr($valorCanVendaEmp, 0, -3);
                   $centVendaCan = substr($valorCanVendaEmp, -3, 2);
                   $valorCanVendaEmp = $realVendaCan.",".$centVendaCan;

$valorVendaEmp = $obj->formataReais($valorVendaEmp, $valorCanVendaEmp, "-");
$valorVendaEmp = $obj->totalValores($valorVendaEmp);
                    
                } else {
                
                    $valorVendaEmp = $obj->totalValores($valorVendaEmp);
                }
                
                

            
            } else
            {
                
               
                
                $valorVendaEmp = str_replace(".", "", "$valorVendaEmp");
                   $realVenda = substr($valorVendaEmp, 0, -3);         
                        $centVenda = substr($valorVendaEmp, -3,2);
                        $valorVendaEmp =  $realVenda.",".$centVenda;
                   $valorCanVendaEmp = str_replace(".","", "$valorCanVendaEmp");
                   $realVendaCan = substr($valorCanVendaEmp, 0, -3);
                   $centVendaCan = substr($valorCanVendaEmp, -3, 2);
                   $valorCanVendaEmp = $realVendaCan.",".$centVendaCan;
                   $valorVendaEmp = $obj->formataReais($valorVendaEmp, $valorCanVendaEmp, "-");
$valorVendaEmp = $obj->totalValores($valorVendaEmp);
                   
                   
                
            }
            $vendaEms = $objMSSQL->retornaVendaEms($dataVenda,$lojaVendaEmp, $venda, $pdvVendaEmp);
            
           $row = mssql_fetch_array($vendaEms);
           
           $qtdVendaEms = $row["QUANTIDADE"];
           $valorVendaEms = $row["VALOR"];
 
           $cancelVendaEms = $objMSSQL->retornaCancelEms($pdvVendaEmp, $lojaVendaEmp, $dataVenda, $venda);
           
           $rowCancel = mssql_fetch_array($cancelVendaEms);
           
           $qtdCancelEms = $rowCancel["QUANTIDADE"];
           $valorCancelVendaEms = $rowCancel["VAL_CAN"];
          $valorVendaEms = number_format($valorVendaEms, 2, ',', '');
          $valorCancelVendaEms = number_format($valorCancelVendaEms, 2, ',', '');
        //  $valorVendaEms = $obj->formataReais($valorVendaEms, $valorCancelVendaEms, "-");
         // $valorVendaEms = $obj->totalValores($valorVendaEms);
          $difVenda = $obj->formataReais($valorVendaEms, $valorVendaEmp, "-");
          $difVenda = $obj->totalValores($difVenda);
          
             
        $lojaAjuste = $obj->editaLoja($valueAjuste["loja"]);
         
                      if (($pdvVendaEmp == $valueAjuste["pdv"]) and ($lojaVendaEmp == $lojaAjuste)){
                          
                          
                
                if($valueAjuste["tipo"] == '4' || $valueAjuste["tipo"] == '6' || $valueAjuste["tipo"] == '1' ){
 
                                     
                $difVenda = $obj->formataReais($difVenda, $valueAjuste["SomaEst"], "+");
                $difVenda = $obj->totalValores($difVenda);
                
               
               
                } elseif($valueAjuste["tipo"] == '3' || $valueAjuste["tipo"] == '5' ||  $valueAjuste["tipo"] == '2'  ) {
                    
                  
                    $difVenda = $obj->formataReais($difVenda, $valueAjuste["SomaInc"], "-");
                       $difVenda = $obj->totalValores($difVenda);
                }
            } else {
                
                
                 
           $difVenda = $obj->formataReais($valorVendaEms, $valorVendaEmp, "-");
           $difVenda = $obj->totalValores($difVenda);    
                
                
            }
           
            //cor do fundo
                         $corfundo = $obj->corfundo($difVenda, $qtdCancelEms, "$qtdCanVendaEmp");
                         
                        
                         if($tipBusca2 == "1"){
                             
                             if($difVenda != ""){
                         
           
           ?>
           
               
                        <tr>
                           <td width="5%" style="text-align: center; background-color:<?php echo $corfundo;?>;" ><?php echo $lojaVendaEmp;?></td>
                            <td width="5%" style="text-align: center; background-color:<?php echo $corfundo;?>;"><?php echo $pdvVendaEmp;?></td>
                             <td width="5%"  style="text-align: center; background-color:<?php echo $corfundo;?>;" ><?php echo $qtdVendaEmp;?></td>
                            <td width="5%"  style="text-align: center; background-color:<?php echo $corfundo;?>;" ><?php echo $valorVendaEmp;?></td>
                              <td width="5%"  style="text-align: center; background-color:<?php echo $corfundo;?>;" ><?php echo $qtdCanVendaEmp;?></td>
                            <td width="5%"  style="text-align: center; background-color:<?php echo $corfundo;?>;" ><?php  echo $valorCanVendaEmp;?></td>
                            <td width="5%"  style="text-align: center; background-color:<?php echo $corfundo;?>;" ><?php echo $qtdVendaEms ;?></td>
                            <td width="5%"  style="text-align: center; background-color:<?php echo $corfundo;?>;" ><?php echo $valorVendaEms;?></td>
                             <td width="5%"  style="text-align: center; background-color:<?php echo $corfundo;?>;" ><?php echo  $qtdCancelEms;?></td>
                            <td width="5%"  style="text-align: center; background-color:<?php echo $corfundo;?>;" ><?php echo  $valorCancelVendaEms; ?></td>
                            <td width="5%" style="text-align: center; background-color:<?php echo $corfundo;?>;" ><?php echo $difVenda;?></td>
                            <td width="5%" style="text-align: center; background-color:<?php echo $corfundo;?>; " ><a target="_blank" class="ui-icon ui-icon-note" href="?router=T0075/listapdvVendas&DataInicial=<?php echo $dataVenda;?>&DataFinal=<?php echo $dataVenda;?>&loja=<?php echo $lojaVendaEmp;?>&pdv=<?php echo $pdvVendaEmp;?>" title="Listar PDV"></a></td>
                            <td width="5%" style="text-align: center; background-color:<?php echo $corfundo;?>; " ><?php if ($loginUserC != ""){?><a target="_blank" class="ui-icon ui-icon-info" href="?router=T0075/ajustes&data=<?php echo $dataVenda;?>&loja=<?php echo $valueAjuste["loja"];?>&pdv=<?php echo $pdvVendaEmp;?>&tipo=<?php echo $valueAjuste["tipo"];?>" title="Observação"></a><?php }?></td>
                              <td width="5%" style="text-align: center; background-color:<?php echo $corfundo;?>; " > <?php if(($pdvVendaEmp  == $pdvVendaObs ) and ($lojaVendaObs == $lojaVendaEmp) ){?><a class="ui-icon ui-icon-check"></a> <?php }?> </td>
                              <td width="5%" style="text-align: center; background-color:<?php echo $corfundo;?>; " >
                              <?php echo str_replace(".",",",$valueAjuste["SomaTotal"]); ?></td>
                          </tr>
<?php 

            $valorVendaEmp = str_replace(",","",$valorVendaEmp);
            $sVendaValEmp +=  $valorVendaEmp;
            $sVendaQtdEmp += $qtdVendaEmp;
            $sVendaQtdCanEmp += $qtdCanVendaEmp;
            $valorCanVendaEmp = str_replace(",", "", $valorCanVendaEmp);
            $sVendaValCanEmp += $valorCanVendaEmp;
            $sVendaQtdEms += $qtdVendaEms;
            $valorVendaEms = str_replace(",", "", $valorVendaEms);
            $sVendaValEms += $valorVendaEms;
            $sVendaQtdCanEms += $qtdCancelEms;
            $valorCancelVendaEms = str_replace(",","", $valorCancelVendaEms);
            $sVendaValCanEms += $valorCancelVendaEms;
            $difVenda = str_replace(",", "", $difVenda);
            $sDifVenda += $difVenda;

}} else {?>

                           <tr>
                           <td width="5%" style="text-align: center; background-color:<?php echo $corfundo;?>;" ><?php echo $lojaVendaEmp;?></td>
                            <td width="5%" style="text-align: center; background-color:<?php echo $corfundo;?>;"><?php echo $pdvVendaEmp;?></td>
                             <td width="5%"  style="text-align: center; background-color:<?php echo $corfundo;?>;" ><?php echo $qtdVendaEmp;?></td>
                            <td width="5%"  style="text-align: center; background-color:<?php echo $corfundo;?>;" ><?php echo $valorVendaEmp;?></td>
                              <td width="5%"  style="text-align: center; background-color:<?php echo $corfundo;?>;" ><?php echo $qtdCanVendaEmp;?></td>
                         <td width="5%"  style="text-align: center; background-color:<?php echo $corfundo;?>;" ><?php   echo $valorCanVendaEmp;?></td>
                            <td width="5%"  style="text-align: center; background-color:<?php echo $corfundo;?>;" ><?php echo $qtdVendaEms ;?></td>
                            <td width="5%"  style="text-align: center; background-color:<?php echo $corfundo;?>;" ><?php echo $valorVendaEms;?></td>
                             <td width="5%"  style="text-align: center; background-color:<?php echo $corfundo;?>;" ><?php echo  $qtdCancelEms;?></td>
                            <td width="5%"  style="text-align: center; background-color:<?php echo $corfundo;?>;" ><?php echo $valorCancelVendaEms;?></td>
                            <td width="5%" style="text-align: center; background-color:<?php echo $corfundo;?>;" ><?php echo $difVenda;?></td>
                            <td width="5%" style="text-align: center; background-color:<?php echo $corfundo;?>; " ><a target="_blank" class="ui-icon ui-icon-note" href="?router=T0075/listapdvVendas&DataInicial=<?php echo $dataVenda;?>&DataFinal=<?php echo $dataVenda;?>&loja=<?php echo $lojaVendaEmp;?>&pdv=<?php echo $pdvVendaEmp;?>" title="Listar PDV"></a></td>
                            <td width="5%" style="text-align: center; background-color:<?php echo $corfundo;?>; " ><?php if($loginUserC != ""){?><a target="_blank" class="ui-icon ui-icon-info" href="?router=T0075/ajustes&data=<?php echo $dataVenda;?>&loja=<?php echo $valueAjuste["loja"];?>&pdv=<?php echo $pdvVendaEmp;?>&tipo=<?php echo $valueAjuste["tipo"];?>" title="Observação"></a><?php }?></td>
                              <td width="5%" style="text-align: center; background-color:<?php echo $corfundo;?>; " > <?php if($valueAjuste["pdv"] == $pdvVendaEmp && $lj == $lojaVendaEmp  ) {echo str_replace(".",",",$valueAjuste["SomaInc"]); } ?> </td>
                                <td width="5%" style="text-align: center; background-color:<?php echo $corfundo;?>; " ><?php   if($valueAjuste["pdv"] == $pdvVendaEmp && $lj == $lojaVendaEmp  ) { echo str_replace(".",",",$valueAjuste["SomaEst"]);} ?></td>
                          </tr>
                          

     <?php   
     
        $valorVendaEmp = str_replace(",","",$valorVendaEmp);
            $sVendaValEmp +=  $valorVendaEmp;
            $sVendaQtdEmp += $qtdVendaEmp;
            $sVendaQtdCanEmp += $qtdCanVendaEmp;
            $valorCanVendaEmp = str_replace(",", "", $valorCanVendaEmp);
            $sVendaValCanEmp += $valorCanVendaEmp;
            $sVendaQtdEms += $qtdVendaEms;
            $valorVendaEms = str_replace(",", "", $valorVendaEms);
            $sVendaValEms += $valorVendaEms;
            $sVendaQtdCanEms += $qtdCancelEms;
            $valorCancelVendaEms = str_replace(",","", $valorCancelVendaEms);
            $sVendaValCanEms += $valorCancelVendaEms;
            $difVenda = str_replace(",", "", $difVenda);
            $sDifVenda += $difVenda;
} }
       }
         

       ?>
                          <tr align="center" style="background-color: #d3d3d3" >
                              <td><b>TOTAL:</b></td>
                              <td></td>
                              <td align = "center">
                                 <?php echo $sVendaQtdEmp;?>
                              </td>
                              <td>
                                  <?php echo $obj->totalValores($sVendaValEmp);?>
                              </td>
                              <td align="center">
                                  <?php echo $sVendaQtdCanEmp;?>
                              </td>
                              <td>
                                <?php echo $obj->totalValores($sVendaValCanEmp);?>
                              </td>
                              <td align="center">
                                  <?php echo $sVendaQtdEms;?>
                              </td>
                              <td>
                                 <?php echo $obj->totalValores($sVendaValEms);?>
                              </td>
                              <td>
                                  <?php echo $sVendaQtdCanEms;?>
                              </td>
                              <td>
                                 <?php echo $obj->totalValores($sVendaValCanEms);?>
                              </td>
                              <td>
                                  <?php echo $obj->totalValores($sDifVenda);?>
                              </td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td>
                                  <?php echo $obj->totalValores($sObsVenda);?>
                              </td>
                          </tr>
        
        </table>
       
       <?php }?>
        </span>
               </div>

        
        </div>
    

    <div id="tabs-3">
        <div id="conteudo">
    <form action="?router=T0075/js.pdf" method="POST" target="_blank" >
   
        <table class="form-inpu-tab">
            <thead>
                 <tr>
                    <th width="8000px"><label>Data </label></th>
                    
                </tr>
                <tr>
                    <td>
                       <input  size="9"  type="text" class="data"  name="DataInicial" value="<?php echo date("d/m/Y"); ?>" />

                    </td>
                    
                    
                     
                    <td>  <input type="submit" id="btnFiltrar" value="Filtrar"/>
            </td>
                </tr>
                        
            </thead>
        </table>
    </form>
            
             
</div>
        
    </div>
    

        </div>
