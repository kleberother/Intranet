<?php
////Instancia Classe
$conn   =   "ora";

$codigoSubGrupo =       $_REQUEST['subgrupo'];
$dataInicial    =       $_REQUEST['dataI'];
$dataFinal      =       $_REQUEST['dataF'];
$lojas          =       $_REQUEST['loja'];


$objORA         = new models_T0109($conn);

$obj            = new models_T0109();

$user           =   $_SESSION['user'];

$comboLoja      =   $obj->retornarLoja(); 

$perfilUsuario  =   $obj->retornaPerfil($user); //48

$lojaUsuario    =   $obj->retornaLojaUsuario($user); //alnascim

$comboLoja      =   $obj->retornaLojas(); 

$aspas          =   ("'");

$grupo          =   $_POST['grupo'];

$porcetagem     =   (" %");

if (!empty($_POST))
    $tipos      =   $_POST['tipo'];
else
    $tipos      = "5";

if (!empty($_POST))
    $subgrupo       =   $_POST['subgrupo'];
else
    $subgrupo       =   $aspas.$codigoSubGrupo.$aspas;
    

//print_r ($grupo);

if (!empty($_POST))
  $loja   =   $_POST['loja'];
    else 
  $loja   =   $lojas;
    


//Data Inical
 
  if (!empty($_POST))
    $dataI  = $obj->retornaDataRMS ($_POST['dataI']);
  else
    $dataI  = $obj->retornaDataRMS ($dataInicial);
    
    
    //Data Final
  if (!empty($_POST))
    $dataF  = $obj->retornaDataRMS ($_POST['dataF']);
  else
    $dataF  = $obj->retornaDataRMS ($dataFinal);


$dados          =  $objORA->retornaItensGrupos($loja, $dataI, $dataF, $tipos, $grupos, $subgrupo);

$grupos         =  $objORA->retornaComboGrupos();

$subgrupos      =  $objORA->retornaComboSubGrupos($grupo);


?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0103/home">Detalhes SubGrupo</a></li>
                <li><a href="?router=T0103/consulta" class="active">Detalhes Itens</a></li>
            </ul>
        </span>
    </div>
</div>

<!-- Divs com filtros oculta -->

<div class="div-primaria div-filtro">
    <form action="" method="post" class="div-filtro-visivel">
        
        <div class="conteudo-visivel padding-5px-vertical">

            <div class="coluna c06_tipo_h_01">       
                <label class="label">Loja</label>
                
                    <?php if($perfilUsuario[0]==47){?>
                    <select name="loja">
                        <option value="">Todas</option>
                        <?php foreach($comboLoja as $campos => $valores){?>
                            <option value="<?php echo $valores['LojaCodigo']?>"           <?php echo $valores['LojaCodigo']==$loja?"selected":"";?>><?php echo $obj->preencheZero("E", 3, $valores['LojaCodigo'])."-".$valores['LojaNome'];?></option>
                        <?php }?>
                     </select>  
                
                    <?php }else if($perfilUsuario[0]==48){?>
                    <select name="loja" disabled>
                        <?php foreach($comboLoja as $campos => $valores){?>
                            <option value="<?php echo $valores['LojaCodigo']?>"            <?php echo $valores['LojaCodigo']==$lojaUsuario?"selected":""?>><?php echo $valores['LojaCodigo']==$lojaUsuario?$obj->preencheZero("E", 3, $valores['LojaCodigo'])."-".$valores['LojaNome']:" 999 - erro";?></option>
                        <?php }?>
                    </select>                                    
                    <?php }?>
               </div>
            
              <div class="coluna c06_tipo_h_02">       
                <label class="label">Grupo</label>
                <select name="grupo">
                    <option value="">Todos...</option>
                    <?php while ($row = oci_fetch_assoc($grupos)){?>
                    <option value="<?php echo $aspas.$row['GRUPO'].$aspas?>" <?php echo $aspas.$row['GRUPO'].$aspas==$grupo?"selected":"";?>><?php echo $row['GRUPO']?></option>
                    <?php }?>
                </select>
               </div> 
            
            
              <div class="coluna c06_tipo_h_03">       
                <label class="label">SubGrupo</label>
                <select name="subgrupo">
                    <option value="">Todos...</option>
                    <?php while ($rows = oci_fetch_assoc($subgrupos)){?>
                    <option value="<?php echo $aspas.$rows['SUBGRUPO'].$aspas?>" <?php echo $aspas.$rows['SUBGRUPO'].$aspas==$subgrupo?"selected":"";?>><?php echo $rows['SUBGRUPO']?></option>
                    <?php }?>
                </select>
               </div>  
 
              <div class="coluna c06_tipo_h_04">       
                <label class="label">Classificar</label>
                <select name="tipo">
                    <option value="5"<?php echo $tipos=="5"?"selected":"";?>>Total Elegíveis</option>
                    <option value="6"<?php echo $tipos=="6"?"selected":"";?>>Total GE</option>
                    <option value="8"<?php echo $tipos=="8"?"selected":"";?>>GE Vendedor</option>
                    <option value="9"<?php echo $tipos=="9"?"selected":"";?>>GE Operador</option>
                </select>
               </div>
            
            <div class="coluna c06_tipo_h_05">       
                 <label class="label">Data Inicial</label>
                 <input type="text" name="dataI" class="data" value="<?php echo $dataInicial;?>" />
            </div>

            <div class="coluna c06_tipo_h_06">       
                <label class="label">Data Final</label>
                <input type="text" name="dataF" class="data" value="<?php echo $dataFinal;?>" />
            </div>  
    
            <div class="padding-5px-vertical margin-padrao-vertical coluna c06_tipo_h_06">
                <input type="submit" class="botao-padrao" value="Filtrar">
            </div>

       </div> 
      
    </form>              
    
</div>

<div class="div-primaria padding-padrao-vertical">
    
  <div id="conteudo">
    <span class="lista_itens">
	<table class="ui-widget ui-widget-content tablesorter" id="tablesorter">
		<thead>
			<tr class="ui-widget-header ">
				<th width="6%">Item</th>
				<th width="24%">Descrição</th>
				<th width="4%">Total Elegíveis</th>
                                <th width="4%">Total GE</th>
                                <th width="4%">Total Penetração</th>
                                <th width="4%">Venda Assistida</th>
                                <th width="4%">GE Vendedor</th>
                                <th width="4%">Penetração Vend.</th>
                                <th width="4%">Elegíveis Operador</th>
                                <th width="4%">GE Operador</th>
                                <th width="4%">Penetração Oper.</th>
			</tr>
		</thead>
                
		<tbody> <?php $i=1;?>
                    <?php while ($row_ora = oci_fetch_assoc($dados)){?> 
			<tr class="dados"> 
                            
                            <?php 
                            $ElegiveisOperador   =  ($row_ora['VENDA']-$row_ora['ELEGIV']);
                            ?>
                            
                                
                            
				<td><?php echo $row_ora['ITEM'];?></td>
				<td><?php echo $row_ora['DESCRICAO'];?></td>
                                <td><?php echo $row_ora['VENDA'];?></td>
                                <td><?php echo $row_ora['QTDGE'];?></td>
                                <td><?php echo number_format($row_ora['QTDGE']/$row_ora['VENDA']*100,2,',',''). $porcetagem;?></td>
                                <td><?php echo $row_ora['ELEGIV'];?></td>
                                <td><?php echo $row_ora['GEVEN'];?></td>
                                <td><?php echo number_format($row_ora['GEVEN']/$row_ora['ELEGIV']*100,2,',',''). $porcetagem;?></td>
                                <td><?php echo $ElegiveisOperador;?></td>
			        <td><?php echo $row_ora['GEOPER'];?></td>
                                <td><?php echo number_format($row_ora['GEOPER']/$ElegiveisOperador*100,2,',',''). $porcetagem;?></td>
                                
                <?php   
                       //TOTAIS
                        $totalVenda     +=   $row_ora['VENDA'];
                        $VendaAssistida +=   $row_ora['ELEGIV'];
                        $VendaEleOper   +=   ($row_ora['VENDA']-$row_ora['ELEGIV']);
                        $totalGE        +=   $row_ora['QTDGE'];
                        $totalGEV       +=   $row_ora['GEVEN'];
                        $totalGEO       +=   $row_ora['GEOPER'];
                ?>
                                
                        </tr>
                                
                 <?php $i++; }?>
                        
               <tr class="ui-widget-header ">
                   
				<th width="6%">Total</th>
				<th width="24"></th>
				<th width="4%"><?php echo $totalVenda;?></th>
                                <th width="4%"><?php echo $totalGE;?></th>
                                <th width="4%"><?php echo number_format($totalGE/$totalVenda*100,2,',',''). $porcetagem;?></th>
                                <th width="4%"><?php echo $VendaAssistida;?></th>
                                <th width="4%"><?php echo $totalGEV;?></th>
                                <th width="4%"><?php echo number_format($totalGEV/$VendaAssistida*100,2,',',''). $porcetagem;?></th>
                                <th width="4%"><?php echo $VendaEleOper;?></th>
                                <th width="4%"><?php echo $totalGEO;?></th>
                                <th width="4%"><?php echo number_format($totalGEO/$VendaEleOper*100,2,',',''). $porcetagem;?></th>
                                
		</tr>
                
        </li>   
                         
                         
                         
                         
                <!-- Caixa Dialogo Excluir -->
                <div id="dialog-confirm" title="Mensagem!" style="display:none">
                    <p><span class="ui-icon ui-icon-alert" style="float:center; margin:0 7px 20px 0;"></span>Tem certeza que deseja excluir este item?</p>
                </div>
                </tbody>
	</table>
    </span>
</div>
