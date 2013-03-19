<?php
////Instancia Classe
$conn   =   "ora";
$objORA    =   new models_T0101($conn);

$obj       =   new models_T0101();
$user           =   $_SESSION['user'];

$perfilUsuario  =   $obj->retornaPerfil($user); //48

$lojaUsuario    =   $obj->retornaLojaUsuario($user); //alnascim

$comboLoja      =   $obj->retornaLoja();    

$mesAno         =   $_POST['mes'];

$mes            =   $obj->retornaMes();

$aspas          = ("'");

$porcetagem     = (" %");

if ($perfilUsuario[0]==47)
    $loja   =   $_POST['loja'];
else 
    $loja   =   $lojaUsuario;


$metas          =   $obj->retornaMetas($mesAno, $loja)  ;


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

            <div class="coluna c05_tipo_g_01">       
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
            
            <div class="coluna c05_tipo_g_02">       
                <label class="label">Mês referência</label>
                <select name="mes">
                        <option value="">Selecione...</option>
                        <?php foreach($mes as $campos => $valores){?>
                        <option value="<?php echo $aspas.$valores['MesMeta'].$aspas?>" <?php echo $aspas.$valores['MesMeta'].$aspas==$mesAno?"selected":"";?>><?php echo $valores['MesMeta']?></option>
                        <?php }?>
                            
                    </select>                    
                </select>
            </div>
            
        </div>          
        
        <div class="conteudo-visivel padding-5px-vertical">

            <div class="padding-5px-vertical margin-padrao-vertical coluna c02_tipo_b_01">
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
				<th width="8%">Loja</th>
				<th width="4%">Mês referência</th>
				<th width="8%">Meta </th>
                                <th width="8%">Realizado</th>
                                <th width="8%">% Realizado</th>
			</tr>
		</thead>
                
		<tbody> <?php $i=1;?>
                        <?php foreach ($metas as $campos=>$valores) {{ ?>
			<tr class="dados">
				<td><?php echo $obj->preencheZero("E",3,$valores['CodigoLoja'])."-".$valores['NomeLoja'];?></td>
				<td><?php echo $valores['MesMeta'];?></td>
                                <td><?php echo money_format("%.2n",$valores['ValorMeta']);?></td>
                                <td><?php echo money_format("%.2n",$objORA->retornaDados($aspas.$valores['MesMeta'].$aspas,$valores['CodigoLoja']));?></td>
                                <td><?php echo number_format($objORA->retornaDados($aspas.$valores['MesMeta'].$aspas,$valores['CodigoLoja'])/$valores['ValorMeta']*100,2,',',''). $porcetagem;?></td>
			        
                                
                                               <?php   
                        //TOTAIS
                        $totalMeta     +=   $valores['ValorMeta'];
                        $totalVenda    +=   ($objORA->retornaDados($aspas.$valores['MesMeta'].$aspas,$valores['CodigoLoja']));
                ?>
                                
                        </tr>
                                
                 <?php $i++; }}?>
                        
               <tr class="ui-widget-header ">
				<th width="8%">Total</th>
				<th width="4%"></th>
				<th width="8%"><?php echo money_format("%.2n",$totalMeta);?></th>
                                <th width="8%"><?php echo money_format("%.2n",$totalVenda);?></th>
                                <th width="8%"><?php echo number_format($totalVenda/$totalMeta*100,2,',',''). $porcetagem;?></th>
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
