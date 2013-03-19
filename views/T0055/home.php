<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 18/10/2011 por Roberta Schimidt                               
 * Descrição: Tela Ranking Cartão
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/

//conexao com BD
$conn               =   "";
$obj = new models_T0055($conn);

$conn               =   "mssql";
$verificaConexao    =   "";
$db                 =   "DBO_CRE";
$objMSSQL = new models_T0055($conn,$verificaConexao,$db); // fim conexao

$usuarioConfianca = $obj->retornaPerfilConfianca($user);

foreach ($usuarioConfianca as $keyUser => $valueUser) 
    {
    $loginUserC = $valueUser["usuario"];
    }

// inicio post parcial cartoes 
$datafim = $_POST['DataInicial'];
$dataini = substr($datafim,6,4)."-".substr($datafim,3,2)."-01";
$datafim = substr($datafim,6,4)."-".substr($datafim,3,2)."-".substr($datafim,0,2);
$tipo2 = $_POST['tipo'];    
$mes= date("m");
$ano = date("Y"); // fim post

?>
<!-- Filtro Dinâmico -->
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0055/home" class="active">Rankings</a></li>
              <?php if ($loginUserC != ""){?>  <li><a href="?router=T0055/manu" >Manutenção</a></li><?php }?>
            </ul>
        </span>
    </div>
</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Cartão</a></li>
        <li><a href="#tabs-2">Seguros</a></li>
        
    </ul>
    <div id="tabs-1">
        <div id="conteudo">
            
    <script language="Javascript">
function mostrar()
{
document.form.recipient.value = "1";
document.form.submit();
document.getElementById('carregando').style.display='inline';
}
</script>
    <form action="#tabs-1" method="post">
        
<?php 

//pegar mes e ano separado das datas de pesquisa
$mes_dataini = substr($dataini, 5,2);
$ano_dataini = substr($dataini, 0,4); //fim 

// tipo da meta 3 = cartões
$tipo = '3';

//retorna projeção correspondente a data.
$projecao = $obj->retornaProjecao($mes_dataini, $ano_dataini);

//retorna meta correspondente ao mes e ano da data
$MetaMes = $obj->retornaMeta($mes_dataini,  $ano_dataini);
                
//formata a data para aparecer após retornar dados.        
$datainiShow = substr($dataini,8,2)."/".substr($dataini,5,2)."/".substr($dataini,0,4);
$datafimShow = substr($datafim,8,2)."/".substr($datafim,5,2)."/".substr($datafim,0,4); 

?>

        <table class="form-inpu-tab">
            <thead>
                 <tr>
                    
                    <th width="8000px"><label>Data</label></th>
                    
                    <th width="8000px"><label>Flash</label></th>
                     <th width="200000px"><label>Parcial</label></th>
                </tr>
            
            <td>
                        <input size="9"  type="text" class="data"   name="DataInicial" value="<?php if($datafim == "--") {echo date("d/m/Y");}else {echo $datafimShow;}?>"/>
                    </td>                    
                    <td>
                        <input type="radio" name="tipo" value="dia"/>
                    </td>
                    <td>
                        <input type="radio" name="tipo" value="mes"/>
                    </td>
                    <td>  <input type="submit" id="btnFiltrar" value="Filtrar" onclick="document.getElementById('carregando').style.display='inline'"/>
            </td>
                </tr>
                        
            </thead>
        </table>
         <div id="carregando" style="display: none;"> Carregando aguarde... </div>
    
        <div class="textarea">
            <span id="carregando"></span>
            <span class="loading">Aguarde Carregando...</span>
        </div>
        </form>
</div>
        <div id="conteudo">
    <span class="lista_itens">
        
            
        <?php
        
  $Udia = substr($datafim,8,2) - 1;
        
        
        
        if ($tipo2 == "mes"){
            
            $colsAp = "4";
            $colsAt = "3";
            $colsAd = "3";
        } else {
            
            $colsAp = "3";
            $colsAt = "2";
            $colsAd = "2";
            
        }
        
      if($datafim != "--"){
        
        ?>
        
        
        
	<table width="80%">
		<thead >
                    <?php if($tipo2 == "mes"){ ?>
			<tr style="background-color: #d3d3d3" >
                       
                            <th width="10%" style="text-align: center;">Loja                   </th>
                            <th width="5%" style="text-align: center;" colspan="<?php echo $colsAp;?>">Aprovados     </th>
                         
                            <th width="5%" colspan="<?php echo $colsAt;?>" style="text-align: center;">Ativados</th>
                            <th width="5%" style="text-align: center;" colspan="<?php echo $colsAd;?>">Adicionais     </th>
                             <th width="5%" style="text-align: center;" >     </th>
                        </tr> <?php } else {?>
                            
                            <tr style="background-color: #d3d3d3" >
                       
                            <th width="10%" style="text-align: center;">Loja                   </th>
                            <th width="5%" style="text-align: center;" colspan="<?php echo $colsAp;?>">Aprovados     </th>
                                 <th width="5%" style="text-align: center;" >     </th>
                        </tr>
                            
                            
                            
                            <?php }?>
                      <?php 
                                if($tipo2 == "mes") {
                          ?>  
                        
                        
               	<tr style="background-color: #d3d3d3">
                       <td width="5%" style="text-align: center;" > <b>    </b>                </td>
                            <td width="5%" style="text-align: center;" > <b> Meta    </b>                </td>
                            <td width="5%" style="text-align: center;" > <b> Captados </b>                </td>
                            <td width="5%" style="text-align: center;" > <b> Aprovados </b>                </td>
                            <td width="5%" style="text-align: center;" > <b> %</b>                </td>
                            <td width="5%" style="text-align: center;"  > <b> Meta </b>                </td>
                            <td width="5%" style="text-align: center;" > <b> Ativados </b>                </td>
                            <td width="5%" style="text-align: center;" > <b> %</b>                </td>
                            <td width="5%" style="text-align: center;"  ><b>Meta</b></td>
                            <td width="5%" style="text-align: center;"  ><b>Adicionais</b></td>
                             <td width="5%" style="text-align: center;" ><b> % </b>  </td>
                             <td width="5%" style="text-align: center;" ><b> Falta </b>  </td>
                        </tr>
               
                          <?php } else {?>
                           
                        <tr style="background-color:#d3d3d3;" >
                            <td width="5%" style="text-align: center;" > <b>    </b>                </td>
                            <td width="5%" style="text-align: center;" > <b> Meta    </b>                </td>
                            <td width="5%" style="text-align: center;" > <b> Captados </b>                </td>
                            <td width="5%" style="text-align: center;" > <b> Aprovados </b>                </td>
                   
                            <td width="5%" style="text-align: center;"  ><b>Falta</b></td>
                           
                        </tr>
                       <?php }?> 
                         
		</thead>
                <tbody > 
 <?php
      
            //inicia soma de valores com 0
            $somaMAp = 0;
            $somaCap = 0;
            $somaAp = 0;
            $somaMAt = 0;
            $somaAt = 0;
            $somaMAd = 0;
            $somaAd = 0;
       
            //retorna valores da projeção        
            foreach ($projecao as $campos=>$valores){
                        
                        $nProj = $valores['T083_projecao'];
                        
                    }
                    
                    //função para retornar ultimo dia do mês
                    $qtd_dias = $obj->UltimoDia($ano_dataini, $mes_dataini);                  
 
//retorna valores das metas  mensais                    
 foreach($MetaMes as $campos=>$valores){
    
    $dataMeta = $valores['T082_mes'];
    $lojaMeta = $valores['T082_loja'];          
    
    //retorna valores da parcial do cartão
    $RankingCartao = $objMSSQL->retornaRankingCartao($dataini, $datafim,  $lojaMeta);

                    
                    $row = mssql_fetch_array($RankingCartao);
                   
                        $loja = $row['LOCAL'];
                        $captados = $row['CAPTADOS']; 
                        $m_ativados = $valores['T082_ativados'];
                    
                      $aprovadosCartao = $objMSSQL->retornaAProvadosParcial($lojaMeta, $datafim);
                      
                      $r_aprovados = mssql_fetch_array($aprovadosCartao);
                        
                        
                   //retorna valores da parcial diaria     
                   $retornaDiaria = $objMSSQL->retornaParcialDia($lojaMeta, $datafim);
                        
                    $linha = mssql_fetch_array($retornaDiaria);
                        
                    $capDia = $linha['CAPTADOS'];  if($capDia == ""){ $capDia = "0";}
                    $apDia = $linha['APROVADOS']; if ($apDia == "") { $apDia = "0";}
                    $atDia = $linha ['ATIVOS']; if ($atDia == "") { $atDia = "0";}
                    $adDia = $linha['ADICIONAIS']; if($adDia == ""){$adDia = "0";}
                    
                        
                //equação para trazer valores da meta diaria 
                 $meta_diaAp = (($valores['T082_aprovados'] - $row['APROVADOS'])/($nProj-$Udia));
                 $meta_diaAt = (($valores['T082_ativados'] - $row['ATIVOS'])/($nProj-$Udia));
                 $meta_diaAd = (($valores['T082_adicionais'] - $row['ADICIONAIS'])/($nProj-$Udia));
                 //fim das equações
                       
                 //soma dos valores 
                 if($tipo2 == "dia" ){
                     
                     $somaCap += $capDia;
                     $somaAp += $apDia;
                     $somaMAp += round($meta_diaAp);
                     $somaAt += $atDia;
                     $somaMAt += round($meta_diaAt);
                     $somaAd += $adDia;
                     $somaMAd += round($meta_diaAd);
                     
                 } else {
                    
                 $somaMAp += $valores['T082_aprovados'];
                 $somaCap = $somaCap + $captados;
                 $somaAp += $row['APROVADOS'];
                 $somaMAt = $somaMAt + $valores['T082_ativados'];
                 $somaAt = $somaAt + $row['ATIVOS'];
                 $somaMAd = $somaMAd + $valores['T082_adicionais'];
                 $somaAd = $somaAd + $row['ADICIONAIS'];
                 
                 }
             
                 
                
                // equação para trazer valor da projeção   / somar valores das projeções  
                 
                 if($tipo2 != "dia"){
                $projAp = ($row['APROVADOS']/$Udia*$nProj);
                $projApInt = round($projAp);
                $somaProjAp+=$projApInt;
                $projAt = ($row['ATIVOS']/$Udia)*$nProj;
                $somaProjAt+=round($projAt);
                $projAd = ($row['ADICIONAIS']/$Udia)*$nProj;
                $somaProjAd+=$projAd; 
                 } else {
                     
                     $projAp = ($apDia/$Udia*$nProj);
                     $somaProjAp+=round($projAp);
                     $projAt = ($atDia/$Udia*$nProj);
                     $somaProjAt+=round($projAt);
                     $projAd = ($adDia/$Udia*$nProj);
                     $somaProjAd +=round($projAd);
                     
                 }
                
                //fim 
                 
                 
                //função para retorno do nome da loja.    
                $nLoja = $objMSSQL->retornaNomeLoja($loja);
                    if($tipo2 == "mes"){
                        
                        $pAprovados = ($projAp /$valores['T082_aprovados'])*100;
                        $pAtivos = ($projAt/$m_ativados)*100;
                        $pAdic = ($projAd/$valores['T082_adicionais'])*100; 
                        
                        $falta = ($valores["T082_aprovados"] - $row["APROVADOS"]);
                        $somaFalta1 += $falta;
                        
                        $corFundo1 = $obj->retornaCorFundo($pAprovados);
                        $corFundo2 = $obj->retornaCorFundo($pAtivos);
                        $corFundo3= $obj->retornaCorFundo($pAdic);
                        
                        
                        
                        
                        
                        
                        
             ?>
            
                    
                        
                    <tr>
                        <td style="text-align: left; background-color:#d3d3d3;" ><b><?php echo $row['LOCAL']." - ".$nLoja;?></b></td>
                       
                        <td style="text-align: center; background-color:#d3d3d3;" ><b><?php  echo $valores['T082_aprovados'];?></b></td>
                         
                        <td style="text-align: center; background-color:<?php echo $corFundo1; ?>; "  ><?php echo $row['CAPTADOS']; if($row['CAPTADOS'] == ""){ $row['CAPTADOS'] = "0";}?></td>
                        <td style="text-align: center; background-color:<?php echo $corFundo1; ?>; " ><?php echo $r_aprovados['APROVADOS'];  if($r_aprovados['APROVADOS']  == ""){ $row['APROVADOS']  = "0";}?></td>
                        <td style="text-align: center; background-color:<?php echo $corFundo1; ?>; " ><?php   echo round($pAprovados)."%"; $somapAP +=$pAprovados; ?></td>
                        <td style="text-align: center; background-color:#d3d3d3;" ><b><?php  echo $valores['T082_ativados']; if( $valores['T082_ativados'] == ""){ $valores['T082_ativados']  = "0";}?></b></td>
                        
                        <td style="text-align: center; background-color:<?php echo $corFundo2; ?>; " ><?php  echo $row['ATIVOS']; if($row['ATIVOS']  == ""){ $row['ATIVOS']  = "0";}?></td>
                        <td style="text-align: center; background-color:<?php echo $corFundo2; ?>; " ><?php  echo round($pAtivos,0)."%"."</font>" ;  $somapAT=$somapAT+$pAtivos;?></td>
                        <td style="text-align: center; background-color:#d3d3d3; " ><b><?php  echo $valores['T082_adicionais']; if( $valores['T082_adicionais'] == ""){ $valores['T082_adicionais']  = "0";}?></b></td>
                         
                        <td style="text-align: center; background-color:<?php echo $corFundo3; ?>; " ><?php  echo $row['ADICIONAIS']; if($row['ADICIONAIS']  == ""){ $row['ADICIONAIS']  = "0";}?></td>
                        <td style="text-align: center; background-color:<?php echo $corFundo3; ?>;  " ><?php  echo round($pAdic,0,PHP_ROUND_HALF_UP)."%"."</font>" ;  $somapAD=$somapAD+$pAdic;?></td>
                        <td style="text-align: center; background-color: #d3d3d3; " ><b><?php  echo $falta;?></b></td>
                       
                    </tr> 
                    <?php } else {
                        
                      $corCap = $obj->retornaCorDia($capDia);
                      $corAp = $obj->retornaCorDia($apDia);
                      $corAt = $obj->retornaCorDia($atDia);
                      $corAd = $obj->retornaCorDia($adDia);
                      $falta =  round($meta_diaAp - $apDia);
                      $somaFalta1 += $falta;
                        
                        ?>
                    
                       <tr>
                        <td style="text-align: left; background-color:#d3d3d3;"><b><?php echo $row['LOCAL']." - ".$nLoja;?></b></td>
                       
                        <td style="text-align: center; background-color:#d3d3d3;"><b><?php  echo round($meta_diaAp);?></b></td>
                         
                        <td style="text-align: center; background-color: <?php echo $corCap ?>;"> <?php  echo $capDia;?></td>
                        <td style="text-align: center; background-color: <?php echo $corAp ?>" ><?php echo $apDia;?></td>
                       

                          <td style="text-align: center; background-color: #d3d3d3; " ><b><?php  echo $falta;?></b></td>
                       
                       
                    </tr> 
                    
                    
                    <?php }   }
                    
                    
                                    if($tipo2 == "mes"){
                        ?>
                             <tr  style="background-color: #d3d3d3" >
                        <td style="text-align: right;" ><b>Total:</b></td>
                        <td style="text-align: center;" ><b><?php echo $somaMAp;?></b></td>
                        
                        <td style="text-align: center;" ><b><?php echo $somaCap;?></b></td>
                        <td style="text-align: center;" ><b><?php echo $somaAp;?></b></td>
                        <td style="text-align: center;" ><b><?php $pSomaAp = (($somaProjAp/$somaMAp)*100);  echo round($pSomaAp,0)."%";?></b></td>
                        <td style="text-align: center;" ><b><?php echo round($somaMAt); ?></b></td>
                        
                        <td style="text-align: center;" ><b><?php echo $somaAt;?></b></td>
                        <td style="text-align: center;" ><b><?php $pSomaAt = ($somaProjAt/$somaMAt)*100; echo round($pSomaAt,0)."%";?></b></td>
                        <td style="text-align: center;" ><b><?php echo $somaMAd;?></b></td>
                     
                        <td style="text-align: center;" ><b><?php echo $somaAd; ?></b></td>
                        <td style="text-align: center;" ><b><?php  $pSomaAd = ($somaProjAd/$somaMAd)*100; echo round($pSomaAd,0)."%";?></b></td>
                          <td style="text-align: center; background-color: #d3d3d3; " ><b><?php  echo $somaFalta1;?></b></td>

                    </tr>
                    
                    <?php } else {?>
                    
                       <tr  style="background-color: #d3d3d3" >
                        <td style="text-align: right;" ><b>Total:</b></td>
                        <td style="text-align: center;" ><b><?php echo $somaMAp;?></b></td>
                        
                        <td style="text-align: center;" ><b><?php echo $somaCap;?></b></td>
                        <td style="text-align: center;" ><b><?php echo $somaAp;?></b></td>
                       
                          <td style="text-align: center; background-color: #d3d3d3; " ><b><?php  echo $somaFalta1;?></b></td>
                       

                    </tr>
                    <?php } }?>
               
                </tbody> 
	</table>
    </span>
        <span class="form-input">
  
        </span>    

</div>
    </div>
 <div id="tabs-2">
     <?php 
     $dataSeg = $_REQUEST['dataSeg'];
     $dataSeg = substr($dataSeg,6,4)."-".substr($dataSeg,3,2)."-".substr($dataSeg,0,2);
     $ano_dataini = substr($dataSeg, 0,4);
     $mes_dataini = substr($dataSeg, 5,2);
     $seguro = $_REQUEST['seguro'];
     $tipoConsulta = $_REQUEST['tipo'];
     $Udia = substr($dataSeg,8,2) - 1;
     
     
        
     
        //formata a data para aparecer após retornar dados.        
        $dataSegShow = substr($dataSeg,8,2)."/".substr($dataSeg,5,2)."/".substr($dataSeg,0,4);
       
        


     ?>
     <div id="conteudo">
             <script language="Javascript">
                function mostrar2()
                {
                document.form.recipient.value = "1";
                document.form.submit();
                document.getElementById('carregando2').style.display='inline';
                }
             </script>
             <form action="#tabs-2" method="post">
                 
                 <table class="form-inpu-tab">
            <thead>
                 <tr>
                    
                    <th width="8000px"><label>Seguro:</label></th>
                    
                    <th width="8000px"><label>Data:</label></th>
                    <th width="8000px"><label>Flash:</label></th>
                     <th width="200000px"><label>Parcial:</label></th>
                </tr>
                     <td>
                         <select id="aps" name="seguro">
                             <option value="0">Selecione...</option>
                             <option value="2">Perda e Roubo </option>
                             <option value="1">Desemprego</option>
                         </select>
                    </td> 
            
            <td>
                        <input size="9"  type="text" class="data"   name="dataSeg" value="<?php if($dataSeg == "--") {echo date("d/m/Y");}else {echo $dataSegShow;}?>"/>
                    </td>                    
                    <td>
                        <input type="radio" name="tipo" value="dia"/>
                    </td>
                    <td>
                        <input type="radio" name="tipo" value="mes"/>
                    </td>
                    <td>  <input type="submit" id="btnFiltrar" value="Filtrar" onclick="document.getElementById('carregando2').style.display='inline'"/>
            </td>
                </tr>
                        
            </thead>
        </table>
                 <div id="carregando2" style="display: none;"> Carregando aguarde... </div>
                 
             </form>
     
             <?php if($dataSeg == "--") {
                 
             } else {?>
         <span class="lista_itens">
             <table width="50%">
		<thead>
			<tr style="background-color: #d3d3d3" >
                            <th width="10%" style="text-align: center;">Loja                                      </th>
                            <th width="5%" style="text-align: center;" colspan="<?php echo $colsAp;?>">Meta       </th>
                             <?php if($seguro == "1")
                            {?>
                            <th width="5%" style="text-align: center;" colspan="<?php echo $colsAd;?>">Elegiveis   </th>
                                <?php } ?>
                            <th width="5%" colspan="<?php echo $colsAt;?>" style="text-align: center;">Realizado  </th>
                            <?php if ($seguro == "2")
                            {?>
                            <th width="5%" style="text-align: center;" colspan="<?php echo $colsAd;?>">PV   </th>
                            <?php }?>
                            <?php if($tipoConsulta == 'mes'){?><th width="5%" style="text-align: center;" colspan="<?php echo $colsAd;?>">Projeção   </th><?php }?>
                            <th width="5%" style="text-align: center;" colspan="<?php echo $colsAd;?>">Falta   </th>
                           
                        </tr>
                </thead>
                <?php 
                $projecao = $obj->retornaProjecao($mes_dataini, $ano_dataini);
                foreach ($projecao as $keyProj => $valueProj) {
                    $projecaoSeguro = $valueProj["T083_projecao"];
                }
                $metaSeguro = $obj->retornaMeta($mes_dataini, $ano_dataini);
                
                foreach($metaSeguro as $keySeguro => $valueSeguro){
                    
                    $realizados = $objMSSQL->retornaSeguro($seguro, $dataSeg, $valueSeguro["T082_loja"], $tipoConsulta);
                    
                    $r_realizado = mssql_fetch_array($realizados);
                    
                    if($seguro == '1'){
                    $elegiveis = $objMSSQL->retornaElegiveis($valueSeguro["T082_loja"], $dataSeg, $tipoConsulta);
                    
                    $r_elegiveis = mssql_fetch_array($elegiveis); }
                    
                    if ($seguro == '2')
                    {
                        $pv = $objMSSQL->selecionaPv($dataSeg, $tipoConsulta, $valueSeguro["T082_loja"]);
                        
                        $r_pv = mssql_fetch_array($pv);
                    }
                    
                    //retorna o nome da loja
                    
                    $nLoja = $objMSSQL->retornaNomeLoja($valueSeguro["T082_loja"]);

//calcula projeção
                    if ($tipoConsulta == "dia") 
                    {
                        if($seguro == 1)
                        {
                        $metaProjSeg = $valueSeguro["T082_desemprego"];
                        } else {
                        $metaProjSeg = $valueSeguro["T082_perda_e_roubo"];    
                        }
                    $metaProjSeg = round(($metaProjSeg - $r_realizado["QTD_TOT"])/(31-$Udia-1)); 
                    } 
                    else
                    {
                    
                    if($seguro == 1)
                        {
                        $metaProjSeg = $valueSeguro["T082_desemprego"];
                        } else {
                        $metaProjSeg = $valueSeguro["T082_perda_e_roubo"];    
                        }
                        
                        
                    
                    $projTotal = ((($r_realizado["QTD_TOT"]/$Udia)*$projecaoSeguro)/$metaProjSeg)*100;
                    
                    }
                    
                    $faltaSeg = ($metaProjSeg - $r_realizado["QTD_TOT"] );
                    
                    //soma os valores
                    
                    $somaMetaSeg += $metaProjSeg;
                    $somaRealizado += $r_realizado["QTD_TOT"];
                    $somaElegiveis += $r_elegiveis["Qtd"];
                    $somaFalta += $faltaSeg;
                    $somaPV += $r_pv["QTD"];
                 
                    
                    //seleciona cor do fundo
                    $corFundo = $obj->retornaCorFalta($r_realizado["QTD_TOT"], $metaProjSeg);
                    
                ?>
                            
                        <tr style="background-color: <?php echo $corFundo;?>;">
                            <td width="10%" style="text-align: left; background-color: #d3d3d3;"><b><?php echo $valueSeguro["T082_loja"]." - ".$nLoja;?></b>                                      </td>
                            <td width="5%" style="text-align: center; background-color: #d3d3d3;" colspan="<?php echo $colsAp;?>"><?php echo $metaProjSeg;?>         </td>
                            <?php if($seguro == "1")
                            {?>
                            <td width="5%" style="text-align: center;" colspan="<?php echo $colsAd;?>"><?php if($r_elegiveis == ""){echo "0";} else {echo $r_elegiveis["Qtd"];}?>   </td>
                                <?php } ?>
                            <td width="5%" colspan="<?php echo $colsAt;?>" style="text-align: center;"> <?php echo $r_realizado["QTD_TOT"]; if($r_realizado["QTD_TOT"] == ""){ echo "0"; }?> </td>
                             <?php if($seguro == "2")
                            {?>
                            <td width="5%" style="text-align: center;" colspan="<?php echo $colsAd;?>"><?php echo $r_pv["QTD"]?>  </td>
                                <?php } ?>
                         <?php if($tipoConsulta == 'mes'){?>   <td width="5%" style="text-align: center;" colspan="<?php echo $colsAd;?>"><?php echo  round($projTotal)."%";?>   </td><?php }?>
                             <td width="5%" style="text-align: center; background-color: #d3d3d3;" colspan="<?php echo $colsAd;?>"><?php echo $faltaSeg;?>   </td>
                            
                        </tr>
                <?php }?>
                        
                           <tr style="background-color: #d3d3d3" >
                            <td width="10%" style="text-align: right;"><b>TOTAL:</b>                               </td>
                            <td width="5%" style="text-align: center;" colspan="<?php echo $colsAp;?>"><b><?php echo $somaMetaSeg;?></b>         </td>
                            <?php } if($seguro == "1")
                            {?>
                            <td width="5%" style="text-align: center;" colspan="<?php echo $colsAd;?>"><b><?php echo $somaElegiveis?>  </b> </td>
                                <?php } ?>
                            <td width="5%" colspan="<?php echo $colsAt;?>" style="text-align: center;"><b> <?php echo $somaRealizado;?></b> </td>
                              <?php  if($seguro == "2")
                              {?>
                            <td width="5%" style="text-align: center;" colspan="<?php echo $colsAd;?>"><b><?php echo $somaPV;?>  </b> </td>
                                <?php } ?>
                            
                            <?php if($tipoConsulta == 'mes'){?><td width="5%" style="text-align: center;" colspan="<?php echo $colsAd;?>"><b><?php    
                    $somaProjTot  = ((($somaRealizado/$Udia)*$projecaoSeguro)/$somaMetaSeg)*100;
                     if($somaProjTot != "0"){echo  round($somaProjTot)."%";}?> </b>  </td> <?php }?>
                                <td width="5%" style="text-align: center;" colspan="<?php echo $colsAd;?>"><b><?php echo $somaFalta;?></b>   </td> 
                                 </tr>
                                   </span>
                                 
              </table>
     </div>
     
     
     
    
    </div>
           
</div>
          
