<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 16/01/2012 por Roberta Schimidt                               
 * Descrição: Tela totais Cartão
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/
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
?>


<script language="Javascript">
function mostrar()
{
document.form.recipient.value = "1";
document.form.submit();
document.getElementById('carregando').style.display='inline';
}
</script>

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
          <li><a href="#tabs-3">Ajustes</a></li>

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
$lojaIn = $_POST['loja'];
$tipBusca = $_POST['TipBusca'];
    
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
                        <select id="aps" name="loja" >
                         <?php 
                         
                         
                         $nLojaPag = $objMSSQL->retornaNomeLojaPag($lojaIn); 
                         
                         if (($lojaIn == "0") or ($lojaIn == "")){?>   
                         <option value="0">Selecione... </option> <?php } 
                         
                         else {?>
                         
                         <option value="<?php echo $lojaIn?>"><?php echo $nLojaPag;?></option> 
                       
                          
                         
                         <?php 
                             }
//retorna valores do combobox Loja
$comboPag = $obj->retornaComboPag();


foreach ($comboPag as $keyComboPag => $valueComboPag)
{   
    //retorna nome das lojas
    $nLojaPag = $objMSSQL->retornaNomeLojaPag($valueComboPag['T006_codigo']);
    
?>
<option value="<?php echo $nLojaPag?>">  <?php echo $nLojaPag." - ".$valueComboPag['T006_nome'];?> </option>
                            
                         
    <?php }?>

                        </select>
                        
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
                         
                         $valorEms = $resEMS["VALOR"];
                         $valorEms = number_format($valorEms, 2, ",", "");
                         $qtdEms = $resEMS["QUANTIDADE"];
                         
                         $cancelamentoPagEms = $objMSSQL->retornaCancelPagEms($pdvEmp, $lojaEmp, $dataini, $datafim);
                         
                         $resCanEms = mssql_fetch_array($cancelamentoPagEms);
                         $valorCancelEms = $resCanEms["VALOR"];
                         $valorCancelEms = number_format($valorCancelEms, 2, ",", "");
                         $qtdCancelEms = $resCanEms["QUANTIDADE"];
                         
                         //calcula valor liquido Emporium
                         
                         if(($pdvEmp == $pdvEst) and ($lojaEmp == $lojaEst)){
                         
                         $valorEmp = $obj->formataReais($valorEmp, $valorEst, "-");
                         $valorEmp = $obj->totalValores($valorEmp);
                         } // fim do calculo de estorno
                         
                         //retorna observação
                         
                         $retornaObs= $obj->retornaObs($pdvEmp, $lojaEmp, "0", $dataini);
                         
                         foreach($retornaObs as $obsKey => $obsValue){
                             
                             $pdvObs = $obsValue["T090_pdv"];
                             $lojaObs = $obsValue["T090_loja"];
                             $valorObs = $obsValue["T090_valor"];
                             $tipoOperacao = $obsValue["T090_tipo_op"];
                             
                             
                         }
                         

                         
                         
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
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $valorEmp;?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php if (($lojaEmp == $lojaEst)and ($pdvEst == $pdvEmp)){echo $qtdEst;}?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php if (($lojaEmp == $lojaEst)and ($pdvEst == $pdvEmp)){  echo $valorEst;}?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $qtdEms;?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $valorEms;?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $qtdCancelEms;?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $valorCancelEms?></td>
                         
                            <td width="5%" style="text-align: center; background-color: <?php echo $corfundo;?>;" > <?php echo $diferencaPag;?>    </td>
             <td width="1%" style="text-align: center; background-color:<?php echo $corfundo;?>;"><a target="_blank" class="ui-icon ui-icon-note" href="?router=T0075/listapdvpag&DataInicial=<?php echo $dataini;?>&DataFinal=<?php echo $dataini;?>&loja=<?php echo $lojaEmp;?>&pdv=<?php echo $pdvEmp;?>" title="Listar PDV"></a>                    </td>
                             <td width="5%" style="text-align: center;  background-color:<?php echo $corfundo;?>;"><a target="_blank" class="ui-icon ui-icon-info" href="?router=T0075/observacoes&data=<?php echo $dataini;?>&loja=<?php echo $lojaEmp;?>&pdv=<?php echo $pdvEmp;?>&final=<?php echo "0";?>"    onmouseover ='show_tooltip_alert("","Clique aqui para adicionar uma Observação", true);'></a></td>
   
                                <td width="1%" style="background-color:<?php echo $corfundo;?>;">  <?php if(($pdvEmp  == $pdvObs ) and ($lojaEmp == $lojaObs)){?><a class="ui-icon ui-icon-check"></a> <?php }?> </td>  
                                   <td width="5%" style="text-align: center; background-color: <?php echo $corfundo;?>;" > <?php if(($pdvEmp  == $pdvObs ) and ($lojaEmp == $lojaObs)){echo $valorObs;  }?></td>
                          </tr>
                    
                         
                    <?php }} else {  ?>
                    
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
                                         <td width="5%" style="text-align: center;  background-color:<?php echo $corfundo;?>;"><a target="_blank" class="ui-icon ui-icon-info" href="?router=T0075/observacoes&data=<?php echo $dataini;?>&loja=<?php echo $lojaEmp;?>&pdv=<?php echo $pdvEmp;?>&final=<?php echo "0";?>" onmouseover ='show_tooltip_alert("","Clique aqui para adicionar uma Observação", true);'></a></td>
   
                                <td width="1%" style="background-color:<?php echo $corfundo;?>;">  <?php if(($pdvEmp  == $pdvObs ) and ($lojaEmp == $lojaObs)){?><a class="ui-icon ui-icon-check"></a> <?php }?> </td>  
                                   <td width="5%" style="text-align: center; background-color: <?php echo $corfundo;?>;" > <?php if(($pdvEmp  == $pdvObs ) and ($lojaEmp == $lojaObs)){echo $valorObs;  }?></td>
                          </tr>
                    
                    
                    
                    <?php
                              
                    }
                              } }
            ?>
                </tbody>
        </table>
    </span>
     

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
                            <?php $finalizadoras = $obj->retornaFinalizadoras($tipVenda);
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
                        <select id="aps" name="lojaVenda" >
                            <?php $nLojaVenda = $objMSSQL->retornaNomeLojaPag($lojaInVenda); 
                         
                         if ($lojaInVenda == ""){?>   
                         <option value="0">   Todas      </option> <?php } 
                         
                         else {?>
                         
                         <option value="<?php echo $lojaInVenda?>"><?php echo $nLojaVenda;?></option>  
                         
                            <?php 
                            }
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
        
            <div id="carregando2" style="display: none;"> Carregando aguarde... </div>
            
               <div id="conteudo">
    <span class="lista_itens">
        
       <?php if ($dataVenda != "--"){?> 
        <table width="80%">
		<thead >
			<tr style="background-color: #d3d3d3" >
                            <th width="5%" style="text-align: center;" >LOJA     </th>
                            <th width="5%" style="text-align: center;">PDV</th>
                            <th width="5%"  style="text-align: center;" colspan="4">Emporium</th>
                            <th width="5%"  style="text-align: center;" colspan="4">EMS</th>
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
                            <th width="5%" style="text-align: center; "  colspan="3">Obs/Ajustes</th>
                          </tr>
               	
		</thead>
                <tbody >
        
        <?php $vendaEmp = $objEMP->retornaVendaEmporium($dataVenda, $venda, $lojaInVenda);
        foreach($vendaEmp as $keyVenda => $valueVenda){
            
            
            $pdvVendaEmp = $valueVenda["pdv"];
            $lojaVendaEmp = $valueVenda["loja"];
            $qtdVendaEmp = $valueVenda["qtd"];
            $valorVendaEmp = $valueVenda["valor"];
            $valorCanVendaEmp = $valueVenda["valorCan"];
            $qtdCanVendaEmp = $valueVenda["qtdCan"];
           
                    
               
            
           
            
        $obsVenda = $obj->retornaObs($pdvVendaEmp, $lojaVendaEmp, $venda, $dataVenda);
            
            foreach ($obsVenda as $keyObs => $valueObs ){
                
                $pdvVendaObs = $valueObs["T090_pdv"];
                $lojaVendaObs = $valueObs["T090_loja"];
                $valorVendaObs = $valueObs["T090_valor"];
                $tipOperacaoObs = $valueObs["T090_tipo_op"];    
                $valorVendaObs = $obj->totalValores($valorVendaObs);
                
            }
            
 
        
            
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
           $valorVendaEms = number_format($valorVendaEms, 2,',','');
           
           $difVenda = $obj->formataReais($valorVendaEms, $valorVendaEmp, "-");
           $difVenda = $obj->totalValores($difVenda);
           
                      if (($pdvVendaEmp == $pdvVendaObs) and ($lojaVendaEmp == $lojaVendaObs)){
                
               
                
                if($tipOperacaoObs == '2'){
                    
                $difVenda = $obj->formataReais($difVenda, $valorVendaObs, "+");
                $difVenda = $obj->totalValores($difVenda);
                
               
                } elseif($tipOperacaoObs == '1') {
                    
                    
                      $difVenda = $obj->formataReais($difVenda, $valorVendaObs, "-");
                       $difVenda = $obj->totalValores($difVenda);
                }
            } else {
                
                 
           $difVenda = $obj->formataReais($valorVendaEms, $valorVendaEmp, "-");
           $difVenda = $obj->totalValores($difVenda);    
                
                
            }
           
            $cancelVendaEms = $objMSSQL->retornaCancelEms($pdvVendaEmp, $lojaVendaEmp, $dataVenda, $venda);
           
           $rowCancel = mssql_fetch_array($cancelVendaEms);
           
           $qtdCancelEms = $rowCancel["QUANTIDADE"];
           $valorCancelVendaEms = $rowCancel["VAL_CAN"];
           $valorCancelVendaEms = number_format($valorCancelVendaEms, 2, ',', '');
           
           
      
           
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
                            <td width="5%" style="text-align: center; background-color:<?php echo $corfundo;?>; " ><a target="_blank" class="ui-icon ui-icon-info" href="?router=T0075/observacoes&data=<?php echo $dataVenda;?>&loja=<?php echo $lojaVendaEmp;?>&pdv=<?php echo $pdvVendaEmp;?>&final=<?php echo $venda;?>" title="Observação"></a></td>
                              <td width="5%" style="text-align: center; background-color:<?php echo $corfundo;?>; " > <?php if(($pdvVendaEmp  == $pdvVendaObs ) and ($lojaVendaObs == $lojaVendaEmp) ){?><a class="ui-icon ui-icon-check"></a> <?php }?> </td>
                                <td width="5%" style="text-align: center; background-color:<?php echo $corfundo;?>; " ><?php if(($pdvVendaEmp == $pdvVendaObs ) and ($lojaVendaObs == $lojaVendaEmp)){echo $valorVendaObs;} ?></td>
                          </tr>
<?php }} else {?>

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
                            <td width="5%" style="text-align: center; background-color:<?php echo $corfundo;?>; " ><a target="_blank" class="ui-icon ui-icon-info" href="?router=T0075/observacoes&data=<?php echo $dataVenda;?>&loja=<?php echo $lojaVendaEmp;?>&pdv=<?php echo $pdvVendaEmp;?>&final=<?php echo $venda;?>" title="Observação"></a></td>
                              <td width="5%" style="text-align: center; background-color:<?php echo $corfundo;?>; " > <?php if(($pdvVendaEmp  == $pdvVendaObs ) and ($lojaVendaObs == $lojaVendaEmp) ){?><a class="ui-icon ui-icon-check"></a> <?php }?> </td>
                                <td width="5%" style="text-align: center; background-color:<?php echo $corfundo;?>; " ><?php if(($pdvVendaEmp == $pdvVendaObs ) and ($lojaVendaObs == $lojaVendaEmp)){echo $valorVendaObs;} ?></td>
                          </tr>
                          

     <?php   
} }
       }
        ?>
        
        </table>
        </span>
               </div>

        
        </div>
    </div>
    
    <div id="tabs-3">
   <div id="conteudo">
     <?php
    
$dataAjuste = $_POST['dataAjuste'];
$dataAjuste = substr($dataAjuste,6,4)."-".substr($dataAjuste,3,2)."-".substr($dataAjuste,0,2);
$lojaInAjus = $_POST['lojaAjus'];
$tipBusca3 = $_POST['TipBusca'];
$venda = '5';

$mes    = date("m");
$ano    = date("Y");
    $dataAjusteView = substr($dataAjuste,8,2)."/".substr($dataAjuste,5,2)."/".substr($dataAjuste,0,4);
       
       ?>
       
    <form action="#tabs-3" method="post">
            <script language="Javascript">
function mostrar()
{
document.form.recipient.value = "1";
document.form.submit();
document.getElementById('carregando3').style.display='inline';
}
</script>
<table class="form-inpu-tab">
            <thead>
                 <tr>
                    <th width="1000px"><label>Data </label></th>
                    <th width="1000px"><label>Buscar</label></th>
                    <th width="10000px"><label>Loja</label></th>
                </tr>
                    <td>
                       <input  size="9"  type="text" class="data"  name="dataAjuste" value="<?php if ($dataAjuste == "--") {echo date("d/m/Y");} else {echo $dataAjusteView;} ?>" />

                    </td>
                   <td>
                        <select id="aps" name="TipBusca" >
                        <?php $buscaTip3 =  $obj->retornaBuscaCombo($tipBusca3);
                        echo $buscaTip3;?>  
                        </select>
                    </td>
                       
                      <td>
                        <select id="aps" name="lojaAjus" >
                            <?php $nLojaAjus = $objMSSQL->retornaNomeLojaPag($lojaInAjus); 
                         
                         if (($lojaInAjus == "")or ($lojaInAjus == "0")){?>   
                         <option value="0">   Todas      </option> <?php } 
                         
                         else {?>
                         
                         <option value="<?php echo $nLojaAjus?>"><?php echo $valueComboAjus["T006_nome"];?></option>  
                         
                            <?php 
                            }
                            //retorna valores do combobox Loja
                            $comboAjus = $obj->retornaComboVend();

                            foreach($comboAjus as $keyComboAjus => $valueComboAjus)
                            {
                                
                                //retorna nome das lojas
                                $nLojaAjus = $obj->retornaNomeLojaVend($valueComboAjus["T006_codigo"])    ?>
              <option value="<?php echo $nLojaAjus?>">  <?php echo $nLojaAjus." - ".$valueComboAjus["T006_nome"];?> </option>
                            
                <?php } if ($lojaInAjus != ""){?>
              <option value="0">    Todas     </option> <?php }?>
                        </select>
                        
                    </td>
                          
                    <td>  <input type="submit" id="btnFiltrar" value="Filtrar" onclick="document.getElementById('carregando3').style.display='inline'"/>
            </td>
                </tr>
                        
            </thead>
        </table>

    </form>
               <div id="carregando3" style="display: none;"> Carregando aguarde... </div>
          
</div>
        
        <div id="conteudo">
    <span class="lista_itens">      
       
          
       <?php 
       if ($lojaInAjus == ""){
           
           
       
       } else {
           
           $Udia = substr($dataAjuste,8,2 );
           
           if($lojaInAjus != 0){
           
           $textoLoja =  $lojaInAjus." - ".$valueComboAjus["T006_nome"]; }
           
           else {
               
               $textoLoja =  "Todas";
               
           }
           
           echo $textoLoja;
           
       ?> 
           <table width="80%">
		<thead >
			<tr style="background-color: #d3d3d3" >
                            <th width="5%" style="text-align: center;" >LOJA     </th>
                            <th width="5%" style="text-align: center;">PDV</th>
                            <th width="5%"  style="text-align: center;" colspan="2">Emporium</th>
                            <th width="5%"  style="text-align: center;" colspan="2">EMS</th>
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
                            <th width="5%"  style="text-align: center;" >Qtd</th>
                            <th width="5%"  style="text-align: center;" >Valor</th>
                            <th width="5%" style="text-align: center;" ></th>
                            <th width="5%" style="text-align: center; " >Listar</th>
                            <th width="5%" style="text-align: center; "  colspan="3">Obs/Ajustes</th>
                          </tr>
               	
		</thead>
                <tbody>
                    <?php 
                    
                    $ajusteEmp = $objEMP->retornaVendaEmporium($dataAjuste, "5", $lojaInAjus);
                    
                    foreach($ajusteEmp as $key=>$value){
                        
                        $valorAjusteEmp = $value["valor"];
                        $valorAjusteEmp = str_replace(".", "", $valorAjusteEmp);
                        
                        $realAjuste = substr($valorAjusteEmp, 0, -3);         
                        $centAjuste = substr($valorAjusteEmp, -3,2);
                        $valorAjusteEmp =  $realAjuste.",".$centAjuste;
                        
                        $pdv = $value["pdv"];
                        $loja = $value["loja"];
                        
                        
                        
                        $ajusteEms = $objMSSQL->retornaVendaEms($dataAjuste, $loja, $venda, $pdv);
                        
                        $row = mssql_fetch_array($ajusteEms);
                            
                            $valAjusteEms = $row["VALOR"];
                             $valAjusteEms = number_format($valAjusteEms, 2,',','');
                            $qtdAjusteEms = $row ["QUANTIDADE"];
                            
                      $difAjuste = $obj->formataReais($valAjusteEms, $valorAjusteEmp, "-");
                      $difAjuste = $obj->totalValores($difAjuste);
                      
                      $corfundo = $obj->corfundo($difAjuste, "");
                      
                      $obsAjuste =  $obj->retornaObs($pdv, $loja, $venda, $dataAjuste);
                      
                      foreach ($obsAjuste as $campos=>$valores){
                          
                          $pdvObs = $valores["T090_pdv"];
                          $lojaObs = $valores["T090_loja"];
                          $valorObs = $valores["T090_valor"];
                          
                      }
                      
                    
                      if(($pdvObs == $pdv) and ($lojaObs == $loja) ){
                          
                          $difAjuste = $obj->formataReais($valorAjusteEmp, $valorObs, "+");
                          $difAjuste = $obj->totalValores($difAjuste);
                          $valorObs = $obj->totalValores($valorObs);
                          
                      }
                      
                     
                      
                      if($tipBusca3 == "1"){
                          
                          if ($difAjuste != ""){
                              
                               
                          ?>
                          
                          
                          <tr>
                             <td width="5%" style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $value["loja"];?></td>
                            <td width="5%" style="text-align: center; background-color: <?php echo $corfundo;?>;"><?php echo $value["pdv"];?></td>
                             <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $value["qtd"];?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $valorAjusteEmp;?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $qtdAjusteEms; ?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $valAjusteEms;?></td>
                            <td width="5%" style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $difAjuste;?></td>
                            <td width="1%" style="text-align: center; background-color: <?php echo $corfundo;?>;  "><a target="_blank" class="ui-icon ui-icon-note" href="?router=T0075/listapdvVendas&DataInicial=<?php echo $dataAjuste;?>&DataFinal=<?php echo $dataAjuste;?>&loja=<?php echo $loja;?>&pdv=<?php echo $pdv;?>" title="Listar PDV"></a>                                       </td>
                           <td width="5%" style="text-align: center;  background-color: <?php echo $corfundo;?>;"><a target="_blank" class="ui-icon ui-icon-info" href="?router=T0075/observacoes&data=<?php echo $dataAjuste;?>&loja=<?php echo $loja;?>&pdv=<?php echo $pdv;?>&final=<?php echo $venda;?>" title="Observação"></a></td>
                       <td width="1%" style="  background-color: <?php echo $corfundo;?>;">  <?php if(($pdv  == $pdvObs )  and ($lojaObs == $loja)){?><a class="ui-icon ui-icon-check"></a> <?php }?>                   </td>
                               <td width="5%" style="text-align: center;  background-color: <?php echo $corfundo;?>; "  ><?php if(($pdv  == $pdvObs )  and ($lojaObs == $loja)){ echo $valorObs;} ?></td>
                           
                    </tr> 
                          
                          
                          
                          <?php
                          
                          
                      } } else {
                             
                        
                        ?>
                      
                        
                        <tr>
                             <td width="5%" style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $value["loja"];?></td>
                            <td width="5%" style="text-align: center; background-color: <?php echo $corfundo;?>;"><?php echo $value["pdv"];?></td>
                             <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $value["qtd"];?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $valorAjusteEmp;?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $qtdAjusteEms; ?></td>
                            <td width="5%"  style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $valAjusteEms;?></td>
                            <td width="5%" style="text-align: center; background-color: <?php echo $corfundo;?>;" ><?php echo $difAjuste;?></td>
                            <td width="1%" style="text-align: center; background-color: <?php echo $corfundo;?>;  "><a target="_blank" class="ui-icon ui-icon-note" href="?router=T0075/listapdvVendas&DataInicial=<?php echo $dataAjuste;?>&DataFinal=<?php echo $dataAjuste;?>&loja=<?php echo $loja;?>&pdv=<?php echo $pdv;?>" title="Listar PDV"></a>                                       </td>
                           <td width="5%" style="text-align: center;  background-color: <?php echo $corfundo;?>;"><a target="_blank" class="ui-icon ui-icon-info" href="?router=T0075/observacoes&data=<?php echo $dataAjuste;?>&loja=<?php echo $loja;?>&pdv=<?php echo $pdv;?>&final=<?php echo $venda;?>" title="Observação"></a></td>
                        <td width="1%" style="  background-color: <?php echo $corfundo;?>;">  <?php if(($pdv  == $pdvObs )  and ($lojaObs == $loja)){?><a class="ui-icon ui-icon-check"></a> <?php }?>                   </td>
                               <td width="5%" style="text-align: center;  background-color: <?php echo $corfundo;?>; "  ><?php if(($pdv  == $pdvObs )  and ($lojaObs == $loja)){ echo $valorObs;} ?></td>
                           
                    </tr> 
              <?php          
                    } }
                    
                    ?>
                    
                </tbody>
           </table>
           <?php } ?>
       
          <span class="form-input">
        <div class="form-inpu-botoes">
        </div>   
        </span>    
          
        
            </div>
    </div>
 
        </div>
