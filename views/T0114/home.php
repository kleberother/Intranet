<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 30/10/2012 por Roberta Schimidt                               
 * Descrição: Ranking Comissão 
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/

$conn = "";
$obj = new models_T0114($conn);

$conn               =   "mssql";
$verificaConexao    =   "";
$db                 =   "DBO_CRE";
$objMSSQL = new models_T0114($conn,$verificaConexao,$db); // fim conexao

$connOra               =       "ora";
$objORA = new models_T0114($connOra);

$connEMP            =  "emporium"                                   ;               
$verificaConexao    =  1                                            ; //se 1 ignora conexao, caso haja erro na conexao com BD do Emporium
$objEMP             =  new models_T0114($connEMP,$verificaConexao)  ;

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0114/home" class="active">Comissões</a></li>
                <li><a href="?router=T0114/CadastroAgenciado" >Angenciados</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="tabs">
        <ul>
        <li><a href="#tabs-1">Comissão</a></li>
        </ul>
        <div id="tabs-1">
            <?php $ano = $_POST["ano"];
                  $mes = $_POST["mes"];
                  $lojaIn = $_POST["loja"]; ?>
            <div id="conteudo">
                <form action="#tabs-1" method="post">
                    <table class="form-inpu-tab">
            <thead>
                 <tr>
                    <th width="8000px"><label>Mês </label></th>
                    <th width="8000px"><label>Ano</label></th>
                    <th width="80000px"><label>Loja</label></th>
                </tr>
            </thead>
            <tr>
            <td><select name="mes">
                    <option value="1">Janeiro</option>
                    <option value="2">Fevereiro</option>
                    <option value="3">Março</option>
                    <option value="4">Abril</option>
                    <option value="5">Maio</option>
                    <option value="6">Junho</option>
                    <option value="7">Julho</option>
                    <option value="8">Agosto</option>
                    <option value="9">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>
                </select></td>
                <td><input type="text" size="9" name="ano"/></td>
                <td>
                        <select  name="loja" >
                         <?php 
                         $nLoja = $obj->retornaNumLoja($lojaIn); 
                        $BuscaLoja = $obj->retornaBuscaComboLoja($lojaIn);
                        echo $BuscaLoja;
                         ?>
                        <?php 
                             //}
//retorna valores do combobox Loja
$comboLoja = $obj->retornaLoja();

foreach ($comboLoja as $keyComboLoja => $valueComboLoja)
{   
    //retorna nome das lojas
    $nLoja = $obj->retornaNumLoja($valueComboLoja['T006_codigo']);
    
?>
<option value="<?php echo $nLoja?>">  <?php echo $nLoja." - ".$valueComboLoja['T006_nome'];?> </option>
                            
                         
    <?php }?></select>
                        
                    </td>
                    <td>  <input type="submit" id="btnFiltrar" value="Filtrar" onclick="document.getElementById('carregando').style.display='inline'"/>
            </td>
            </tr>
                    </table>
                </form>
                <div id="carregando" style="display: none;"> Carregando aguarde... </div>
</div>
            <div id="conteudo">
                <span class="lista_itens">
                    <?php   if($ano != "" && ($mes != "" || $mes != "0")){?>
                    <table width="80%">
		<thead>
			<tr style="background-color: #d3d3d3" >
                            <th width="5%"  style="text-align: center;" >RANKING                 </th>
                            <th width="5%" style="text-align: center;" >LOJA                     </th>
                            <th width="5%"  style="text-align: center;" >CONTRATADO              </th>
                            <th width="15%"  style="text-align: center;" >COLABORADOR             </th>
                            <th width="5%"  style="text-align: center;" >FUNÇÃO                  </th>
                            <th width="10%"  style="text-align: center;" >CPF                    </th>
                            <th width="5%"  style="text-align: center;" >CARTÕES INDICADOS       </th>
                            <th width="5%"  style="text-align: center;" >SEGUROS PAGOS           </th>
                            <th width="5%"  style="text-align: center;" >VENDA PV                </th>
                            <th width="5%"  style="text-align: center;" >R$                      </th>
                          </tr>
                </thead>
                <tbody>
                    <?php 
                    
                  
                    
                    $condicaoInsere = $obj->retornaDataRanking($mes, $ano);
                    
                    foreach($condicaoInsere as $campInsere => $valInsere);
                   
                  //  if(1==1){
                  if($valInsere["T110_Mes"] != $mes && $valInsere["T110_Ano"] != $ano){
                      
                      //echo "oi";
                      
                        $FuncAtivos = $obj->retornaFuncAtivo($lojaIn);
                            foreach($FuncAtivos as $camposFA => $valorFA){
                                
                                if(strlen($valorFA["CONTRATADO"]) > "5"){
                                
                                $contratadoEMS = substr($valorFA["CONTRATADO"], 1);} else {
                                    
                                     $contratadoEMS = $valorFA["CONTRATADO"];
                                }
                                
                                
                                
                                $retornaIndicados = $objMSSQL->retornaNumIndicados($mes, $ano,$contratadoEMS );
                                
                                $rowInd = mssql_fetch_array($retornaIndicados);
                                
                                $retornaSeguro = $objMSSQL->retornaValComSeg($mes, $ano, $contratadoEMS );
                                
                                $rowSeg = mssql_fetch_array($retornaSeguro);
                                        
                                $valorFA["CPF"] = str_replace("-","",$valorFA["CPF"]);
                                        
                                            
                                $cpfsemzeros = ltrim($valorFA["CPF"], "0");
                               
                                $retornaCodRms = $objORA->retornaCodigoRms($cpfsemzeros);
                                
                            
                                $rowOra = oci_fetch_array($retornaCodRms);
                                
                                $retornaValPv = $objEMP->retornaValPv($rowOra["CODRMS"], $mes, $ano, $valorFA["CONTRATADO"]);
                                
                                $rowPv = $retornaValPv->fetch(PDO::FETCH_OBJ);
                                
                                $valuePv = $rowPv->QTD; 
                                
                                
                                if($rowSeg["VALOR"] == ""){
                                    $rowSeg["VALOR"] = "0";
                                }
                                
                                if($rowInd["QUANTIDADE"] == ""){
                                    $rowInd["QUANTIDADE"] = "0";
                                }
                                
                                if($rowAtiv["QUANTIDADE"] == ""){
                                    $rowAtiv["QUANTIDADE"] =  "0";  
                                }
                                
                                if($valuePv == ""){
                                    $valuePv =  "0";  
                                }
                                
                             $valorFA["CPF"] = str_replace("-","",$valorFA["CPF"]);
                                    
                                    $valorPv = ($valuePv * 0.5);
                                    
                                    $total = (($rowInd["QUANTIDADE"] * 0.5)+$rowSeg["VALOR"]+$valorPv);
                                    
                            //        echo $valorFA["NOME"]." - ".$total." - ".$rowInd["QUANTIDADE"]." - ".$rowSeg["VALOR"]." - ".$valorPv."<br>";
                                    
                                    if ($total != "" || $total != "0.00" || $total != "0" ){
                                    
                                $campos = array("T110_Loja"         =>  $valorFA["LOJA"]
                                                ,"T110_Contratado"  =>  $valorFA["CONTRATADO"]
                                                ,"T110_Colaborador" =>  $valorFA["NOME"]
                                                ,"T110_Funcao"      =>  $valorFA["CARGO"]
                                                ,"T110_Cpf"         =>  $valorFA["CPF"]
                                                ,"T110_CartInd"     =>  $rowInd["QUANTIDADE"]
                                                ,"t110_Ativ"        =>  $rowAtiv["QUANTIDADE"]
                                                ,"T110_SegPag"      =>  $rowSeg["VALOR"]
                                                ,"T110_VendPv"      =>  $valorPv
                                                ,"T110_ValorTot"    =>  $total
                                                ,"T110_Mes"         =>  $mes
                                                ,"T110_Ano"         =>  $ano);
                                
                                $tabela = "T110_RankingComissao";
                                
                            //      $obj->inserir($tabela, $campos);         
                                
                                  } } 
                                
                                $retornaRanking = $obj->retornaRanking($mes, $ano, $lojaIn);
                                
                                foreach($retornaRanking as $campRank => $valRank){ 
                                    
                                    
                                    ?> 
                                
                                
                                 <tr>
                            <td width="5%"  style="text-align: center;" ></td>
                            <td width="5%" style="text-align: center;" > <?php echo $valRank["T110_Loja"];?></td>
                            <td width="5%"  style="text-align: center;" ><?php echo $valRank["T110_Contratado"];?>              </td>
                            <td width="15%"  style="text-align: center;" ><?php echo $valRank["T110_Colaborador"];?> </td>
                            <td width="5%"  style="text-align: center;" ><?php echo $valRank["T110_Funcao"];?></td>
                            <td width="10%"  style="text-align: center;" ><?php echo $valRank["T110_Cpf"];?>                    </td>
                            <td width="5%"  style="text-align: center;" ><?php echo $valRank["T110_CartInd"];?>       </td>
                            <td width="5%"  style="text-align: center;" ><?php echo $valRank["T110_SegPag"];?>            </td>
                            <td width="5%"  style="text-align: center;" >  <?php echo $valRank["T110_VendPv"];?>            </td>
                            <td width="5%"  style="text-align: center;" >R$<?php echo $valRank["T110_ValorTot"];?>               </td>
                          </tr>
                                    
                                    
                                    <?php
                                
                                }
                                
                            
                      
                  } else {
                             
                      $retornaRanking = $obj->retornaRanking($mes, $ano, $lojaIn);
                                
                                foreach($retornaRanking as $campRank => $valRank){
                      
                        
                                
                                ?>
                                
                          <tr>
                            <td width="5%"  style="text-align: center;" ></td>
                            <td width="5%" style="text-align: center;" > <?php echo $valRank["T110_Loja"];?></td>
                            <td width="5%"  style="text-align: center;" ><?php echo $valRank["T110_Contratado"];?>              </td>
                            <td width="15%"  style="text-align: center;" ><?php echo $valRank["T110_Colaborador"];?> </td>
                            <td width="5%"  style="text-align: center;" ><?php echo $valRank["T110_Funcao"];?></td>
                            <td width="10%"  style="text-align: center;" ><?php echo $valRank["T110_Cpf"];?>                    </td>
                            <td width="5%"  style="text-align: center;" ><?php echo $valRank["T110_CartInd"];?>       </td>
                            <td width="5%"  style="text-align: center;" ><?php echo $valRank["T110_SegPag"];?>            </td>
                            <td width="5%"  style="text-align: center;" >  <?php echo $valRank["T110_VendPv"];?>            </td>
                            <td width="5%"  style="text-align: center;" >R$<?php echo $valRank["T110_ValorTot"];?>               </td>
                          </tr>
                                
                                
                                
                                
                                <?php
                                }
                            
                  }
                    }
                    
?>
                    
                </tbody>
                    </table>
                </span>
            </div>
            
            </div>
</div>
</div>

