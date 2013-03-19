<?php
////Instancia Classe
$conn   =   "ora";

$objORA         = new models_T0103($conn);

$obj            = new models_T0103();

$user           =   $_SESSION['user'];

$comboLoja      =   $obj->retornarLoja(); 

$perfilUsuario  =   $obj->retornaPerfil($user); //48

$lojaUsuario    =   $obj->retornaLojaUsuario($user); //alnascim

$comboLoja      =   $obj->retornaLojas(); 

$aspas          =   ("'");

$tipo           =   $_POST['tipo'];

$grupo          =   $_POST['grupo'];

$subgrupo       =   $_POST['subgrupo'];

$loja           =   $_POST['loja'];

$porcetagem     =   (" %");




//print_r ($grupo);

if (!empty($_POST))
{
    if ($perfilUsuario[0]==47)
        $loja   =   $_POST['loja'];
    else 
        $loja   =   $lojaUsuario;
  }


//Data Inical
 
  if (!empty($_POST)) {
      $dataInicial  = $_POST['dataI'];
      $dataI  = $obj->retornaDataRMS ($_POST['dataI']);
    }
    
  else
    $dataInicial  = date("d/m/Y",mktime(-1));
    
    
    //Data Final
  if (!empty($_POST)){
    $dataFinal  = $_POST['dataF'];
    $dataF      = $obj->retornaDataRMS ($_POST['dataF']);
  }
   else 
    $dataFinal  = date("d/m/Y",mktime(-1));
  

$dados          =  $objORA->retornaGrupos($loja, $dataI,$dataF, $tipo, $grupo, $subgrupo);

$grupos         =  $objORA->retornaComboGrupos();

$subgrupos      =  $objORA->retornaComboSubGrupos($grupo);


?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0103/home" class="active">Detalhes SubGrupo</a></li>
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
                    <option value="3"<?php echo $tipo=="3"?"selected":"";?>>Total Elegíveis</option>
                    <option value="4"<?php echo $tipo=="4"?"selected":"";?>>Total GE</option>
                    <option value="6"<?php echo $tipo=="6"?"selected":"";?>>GE Vendedor</option>
                    <option value="7"<?php echo $tipo=="7"?"selected":"";?>>GE Operador</option>
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
				<th width="9%">Grupo</th>
				<th width="9%">SubGrupo</th>
				<th width="6%">Total Elegidos</th>
                                <th width="6%">Total GE</th>
                                <th width="6%">Total Penetração</th>
                                <th width="6%">Venda Assistida</th>
                                <th width="6%">GE Vendedor</th>
                                <th width="6%">Penetração Vend.</th>
                                <th width="6%">Elegidos Operador</th>
                                <th width="6%">GE Operador</th>
                                <th width="6%">Penetração Oper.</th>
			</tr>
		</thead>
                
		<tbody> <?php $i=1;?>
                    <?php while ($row_ora = oci_fetch_assoc($dados)){?> 
			<tr class="dados"> 
                            
                            <?php 
                            $ElegiveisOperador   =  ($row_ora['VENDA_ELEGIDOS_GERAL']-$row_ora['ELEGI_VENDEDOR']);
                            ?>
                            
                                
                            
				<td><?php echo $row_ora['GRUPO'];?></td>
				<td><a target="_blank" href="?router=T0103/consulta&subgrupo=<?php echo $row_ora['SUBGRUPO']; ?>&dataI=<?php echo $dataInicial; ?>&dataF=<?php echo $dataFinal; ?>&loja=<?php echo $loja; ?>"> <?php echo $row_ora['SUBGRUPO'];?></a></td>
                                <td><?php echo $row_ora['VENDA_ELEGIDOS_GERAL'];?></td>
                                <td><?php echo $row_ora['QTDGE_GERAL'];?></td>
                                <td><?php echo number_format($row_ora['QTDGE_GERAL']/$row_ora['VENDA_ELEGIDOS_GERAL']*100,2,',',''). $porcetagem;?></td>
                                <td><?php echo $row_ora['ELEGI_VENDEDOR'];?></td>
                                <td><?php echo $row_ora['GEVEN'];?></td>
                                <td><?php echo number_format($row_ora['GEVEN']/$row_ora['ELEGI_VENDEDOR']*100,2,',',''). $porcetagem;?></td>
                                <td><?php echo $ElegiveisOperador;?></td>
			        <td><?php echo $row_ora['GEOPER'];?></td>
                                <td><?php echo number_format($row_ora['GEOPER']/$ElegiveisOperador*100,2,',',''). $porcetagem;?></td>
                                
                <?php   
                       //TOTAIS
                        $totalVenda     +=   $row_ora['VENDA_ELEGIDOS_GERAL'];
                        $VendaAssistida +=   $row_ora['ELEGI_VENDEDOR'];
                        $VendaEleOper   +=   ($row_ora['VENDA_ELEGIDOS_GERAL']-$row_ora['ELEGIV']);
                        $totalGE        +=   $row_ora['QTDGE_GERAL'];
                        $totalGEV       +=   $row_ora['GEVEN'];
                        $totalGEO       +=   $row_ora['GEOPER'];
                ?>
                                
                        </tr>
                                
                 <?php $i++; }?>
                        
               <tr class="ui-widget-header ">
                   
				<th width="9%">Total</th>
				<th width="9%"></th>
				<th width="6%"><?php echo $totalVenda;?></th>
                                <th width="6%"><?php echo $totalGE;?></th>
                                <th width="6%"><?php echo number_format($totalGE/$totalVenda*100,2,',',''). $porcetagem;?></th>
                                <th width="6%"><?php echo $VendaAssistida;?></th>
                                <th width="6%"><?php echo $totalGEV;?></th>
                                <th width="6%"><?php echo number_format($totalGEV/$VendaAssistida*100,2,',',''). $porcetagem;?></th>
                                <th width="6%"><?php echo $VendaEleOper;?></th>
                                <th width="6%"><?php echo $totalGEO;?></th>
                                <th width="6%"><?php echo number_format($totalGEO/$VendaEleOper*100,2,',',''). $porcetagem;?></th>
                                
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
