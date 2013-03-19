<?php
////Instancia Classe
$conn   =   "ora";

$objORA         = new models_T0107($conn);

$obj            = new models_T0107();

$user           =   $_SESSION['user'];

$comboLoja      =   $obj->retornarLoja(); 

$perfilUsuario  =   $obj->retornaPerfil($user); //48

$lojaUsuario    =   $obj->retornaLojaUsuario($user); //alnascim

$comboLoja      =   $obj->retornaLojas(); 

$aspas          = (" %");

$barra          = ("/");



//print_r ($grupo);

if (!empty($_POST))
{
    if ($perfilUsuario[0]==47)
        $loja   =   $_POST['loja'];
    else 
        $loja   =   $lojaUsuario;
}

$labore         =  $objORA->retornaLabore($loja);


//print_r ($dados);

?>

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="#"                     class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-filter"  ></span>Filtros </a></li>
    </ul>
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
				<th width="1%">Data</th>
				<th width="9%">Venda (=)</th>
				<th width="9%">IOF (-)</th>
                                <th width="9%">Prêmio Liq. (=)</th>
                                <th width="9%">PIS (-)</th>
                                <th width="9%">COFINS (-)</th>                                
                                <th width="9%">Prêmio NET (-)</th>
                                <th width="9%">Pró-Labore (=)</th>
                                <th width="9%">Comissão (-)</th>
                                <th width="9%">IRRF (-)</th>
                                <th width="9%">ISS (-)</th>
                                <th width="9%">Pró-Labore Liq. de IRRF (=)</th>
                                <th width="9%">Margem</th>
			</tr>
		</thead>
                
		<tbody> <?php $i=1;?>
                        <?php while ($row = oci_fetch_assoc($labore)) { 
                            
                            // Inicializa variável com nulo, para casos em que nao existe dado na tabela
                            $PctComissao = NULL ;
                            
                            
                            $Metas      =   $obj->retornaMetas($row['DATAM'].$barra.$row['DATAY'],$_POST['loja']); 
                            foreach ( $Metas as $campos=>$valores)
                            {
                                $PctComissao = $valores['PctComissao'];
                            }
                            // Verifica se encontrou comissao cadastrada na tabela
                            if (empty($PctComissao)) 
                            {
                               $PctComissao=0.1;
                            }else
                            {
                               $PctComissao=round(($PctComissao)/100,2);
                            }
                            
                             $dataMY     = $row['DATAM'].$barra.$row['DATAY'];
                             $Preço      = $row['PRECO'];
                             $IOF        = $row['PRECO']*0.0738;
                             $PremioLiq  = $row['PRECO'] - $IOF ;
                             $PIS        = $PremioLiq*0.0065 ;
                             $Cofins     = $PremioLiq*0.0400;
                             $Custo      = $row['CUSTO'];
                             $ProLaboreI = ($PremioLiq) -($Custo+$PIS+$Cofins);
                             $Comissão   = $row['PRECO']*$PctComissao;
                             $IRRF       = $ProLaboreI*0.0150;
                             $ISS        = $ProLaboreI*0.0200;
                             $ProLaboreF = ($ProLaboreI) -($Comissão+$IRRF);
                             $Margem     = abs($Custo/$Preço-1)*100;
                         
                    ?>
                    
			<tr class="dados"> 
				<td><?php echo $dataMY;?></td>
				<td><?php echo money_format("%.2n",$Preço);?></td>
                                <td><?php echo money_format("%.2n",$IOF);?></td>
                                <td><?php echo money_format("%.2n",$PremioLiq);?></td>
                                <td><?php echo money_format("%.2n",$PIS);?></td>
                                <td><?php echo money_format("%.2n",$Cofins);?></td>
                                <td><?php echo money_format("%.2n",$Custo);?></td>
                                <td><?php echo money_format("%.2n",$ProLaboreI);?></td>
                                <td><?php echo money_format("%.2n",$Comissão);?></td>
                                <td><?php echo money_format("%.2n",$IRRF);?></td>
                                <td><?php echo money_format("%.2n",$ISS);?></td>
                                <td><?php echo money_format("%.2n",$ProLaboreF);?></td>
                                <td><?php echo number_format($Margem,2,',',''). $aspas;?></td>
                         </tr>
                                
                 
                         
                         <?php
                         
                         
                         
                         $TPreço      += $Preço;
                         $TIOF        += $IOF;
                         $TPremioLiq  += $PremioLiq;
                         $TPIS        += $PIS;
                         $TCofins     += $Cofins;
                         $TCusto      += $Custo;
                         $TProLaboreI += $ProLaboreI;
                         $TComissão   += $Comissão;
                         $TIRRF       += $IRRF;
                         $TProLaboreF += $ProLaboreF;
                         $TISS        += $ISS;
                         $TMargem      = abs($TCusto/$TPreço-1)*100;
                          
                         ?>
                 <?php $i++; }?>       
               <tr class="ui-widget-header ">
				<th width="9%">Total</th>
				<th width="6%"><?php echo money_format("%.2n",$TPreço);?></th>
                                <th width="6%"><?php echo money_format("%.2n",$TIOF);?></th>
                                <th width="6%"><?php echo money_format("%.2n",$TPremioLiq);?></th>
                                <th width="6%"><?php echo money_format("%.2n",$TPIS);?></th>
                                <th width="6%"><?php echo money_format("%.2n",$TCofins);?></th>
                                <th width="6%"><?php echo money_format("%.2n",$TCusto);?></th>
                                <th width="6%"><?php echo money_format("%.2n",$TProLaboreI);?></th>
                                <th width="6%"><?php echo money_format("%.2n",$TComissão);?></th>
                                <th width="6%"><?php echo money_format("%.2n",$TIRRF);?></th>
                                <th width="6%"><?php echo money_format("%.2n",$TISS);?></th>
                                <th width="6%"><?php echo money_format("%.2n",$TProLaboreF);?></th>
                                <th width="6%"><?php echo number_format($TMargem,2,',',''). $aspas;?></th>
                                
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
