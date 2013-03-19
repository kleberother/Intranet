
<?php
///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 19/10/2012 por Alexandre Alves
// * Descrição: Programa de Conciliacao Correspondente Bancario (COBAN)
// * Entrada:   
// * Origens:   
//           
//**************************************************************************


//Instancia Classe
$obj       =   new models_T0112();
$conn      =   "ora";
$objORA    =   new models_T0112($conn);

$user           =   $_SESSION['user'];

// verifica se chamou js de limpar os campos
if($_POST['limparHidden'])
  unset($_POST);

$SelectBoxLoja       =   $obj->retornaLojasSelectBox();
$SelectBoxStatus     = $objORA->retornaStatusConciliacoes ();
$SelectBoxTransacoes = $objORA->retornaTiposTransacoes ();
$SelectBoxEstadosTransacoes =   $objORA->retornaEstadosTransacoes ();


if (!empty($_POST))
{
    // seta valores para filtro
    $loja         =  $_POST['loja'];
    $status       =  $_POST['status'];
    $codTransacao =  $_POST['codTransacao'];
    $estadoTransacao =  $_POST['estadoTransacao'];
    $dataCI       =  $_POST['dataCI'];   
    $dataCF       =  $_POST['dataCF'];   
    $dataMI       =  $_POST['dataMI'];     
    $dataMF       =  $_POST['dataMF'];   
    $qtdeReg      =  $_POST['qtdeReg'];     
    
    // verifica se nao foi informada nenhuma data contabil e considera como mes atual
    if ((empty($_POST['dataCI'])) && (empty($_POST['dataCF'])))
    {
      $dataCI = "01/".date("m")."/".date("Y");
      $dataCF = date("t/m/Y");
    }  
    // verifica se nao foi informada nenhuma data contabil e considera como ontem
//    if ((empty($_POST['dataCI'])) && (empty($_POST['dataCF'])))
//    {
//      $dataCI = date("d")-1."/".date("m")."/".date("Y");
//      $dataCF = date("d")-1."/".date("m")."/".date("Y");
//    }  

    
    if (empty($_POST['status']))    
    // verifica se nao foi informado um status, marca "aguardando" como padrao
    $status = "1";
    
    
    // carrega transacacoes somente se foi clicado no botao Filtrar
    $TransacoesCB = $objORA->retornaTransacoesCB($loja,$status,$codTransacao,$estadoTransacao,$dataCI,$dataCF,$dataMI,$dataMF,$qtdeReg);    
    $QtdeTotal   = 0 ;
    $ValorTotal  = 0 ;        
}


?>

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="#"                     class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-filter"  ></span>Filtros </a></li>
        <li><a href="<?php echo ROUTER."home";?>"                class="botao-padrao"><span class="ui-icon ui-icon-image"  ></span>Resumo</a></li>
        <li><a href="<?php echo ROUTER."espelhoBB";?>"           class="botao-padrao"><span class="ui-icon ui-icon-document-b"  ></span>Espelho BB</a></li>
        <li><a style="color:red;" href="<?php echo ROUTER."transacoesCB";?>"        class="botao-padrao"><span class="ui-icon ui-icon-note"  ></span>Transações CB</a></li>

    </ul>
</div>

<div class="conteudo_16 div-primaria div-filtro conteudo-visivel">
 <form action="" method="post" class="div-filtro-visivel" id="T0112">    
    <div class="grid_4">
        <label class="label">Loja</label>
        <select name="loja">
            <option value="">Todas</option>
            <?php foreach($SelectBoxLoja as $campos=>$valores){?>
            <option value="<?php echo $valores['LojaCodigo']?>" <?php echo $valores['LojaCodigo']==$loja?"selected":"";?>><?php echo $obj->preencheZero("E",3,$valores['LojaCodigo'])."-".$valores['LojaNome'];?></option>
            <?php }?>
        </select>                                       
    </div>
    <div class="grid_4">
        <label class="label">Status Conciliação</label>                
        <select name="status">
            <option value="">Selecione...</option>
            <option value="999" <?php echo $status=='999'?"selected":"";?>>Todos</option>
        <?php 
            while ($valores = oci_fetch_assoc($SelectBoxStatus))
            { ?>
                <option value="<?php echo $valores['CSCCODIGO']?>"<?php echo $status==$valores['CSCCODIGO']?"selected":"";?>><?php echo $obj->preencheZero("E",3,$valores['CSCCODIGO'])."-".$valores['CSCDESCRICAO'];?></option>
       <?php 
            } ?> 
            
        </select>
    </div>    
    <div class="grid_4">
        <label class="label">Transação</label>                
        <select name="codTransacao">
            <option value="">Todos</option>
        <?php 
            while ($valores = oci_fetch_assoc($SelectBoxTransacoes))
            { ?>
                <option value="<?php echo $valores['CCTCODIGO']?>"<?php echo $codTransacao==$valores['CCTCODIGO']?"selected":"";?>><?php echo $obj->preencheZero("E",3,$valores['CCTCODIGO'])."-".$valores['CCTDESCRICAO'];?></option>
       <?php 
            } ?>    
        </select>
    </div>    
    <div class="grid_3">
        <label class="label">Estado Transação</label>                
        <select name="estadoTransacao">
            <option value="">Todos</option>
        <?php 
            while ($valores = oci_fetch_assoc($SelectBoxEstadosTransacoes))
            { ?>
                <option value="<?php echo $valores['CETCODIGO']?>"<?php echo $estadoTransacao==$valores['CETCODIGO']?"selected":"";?>><?php echo $obj->preencheZero("E",3,$valores['CETCODIGO'])."-".$valores['CETDESCRICAO'];?></option>
       <?php 
            } ?>    
        </select>
    </div>          
  
    <div class="clear"></div>
    <div class="grid_3">
        <label class="label">Data Contabil Ini.</label>
        <input type="text" name="dataCI" class="data" value="<?php echo $dataCI;?>" />
    </div>
    <div class="grid_3">        
        <label class="label">Data Contabil Fin.</label>
        <input type="text" name="dataCF" class="data" value="<?php echo $dataCF;?>" />
    </div>    
    <div class="grid_3">
        <label class="label">Data Movimento Ini.</label>
        <input type="text" name="dataMI" class="data" value="<?php echo $dataMI;?>" />
    </div>
    <div class="grid_3">        
        <label class="label">Data Movimento Fin.</label>
        <input type="text" name="dataMF" class="data" value="<?php echo $dataMF;?>" />
    </div>    
    <div class="grid_3">
        <label class="label">Qtde Registros</label>                
        <select name="qtdeReg">
            <option value="100"<?php echo  $qtdeReg==100?"selected":"";?> >100</option>
            <option value="1000"<?php echo $qtdeReg==1000?"selected":"";?>>1000</option>
            <option value="5000"<?php echo $qtdeReg==5000?"selected":"";?>>5000</option>
            <option value="">Todos</option>
        </select>
    </div>           
    <div class="clear"></div>
    <div class="grid_2 prefix_12">
        <input type="button" class="botao-padrao limpar" value="Limpar">
        <input type="hidden" class="botao-padrao limparHidden" value="0" name="limparHidden">
    </div>
    <div class="grid_2">
        <input type="submit" class="botao-padrao" value="Filtrar">
    </div>

 </form>  
    <div class="clear10"></div>    

	<table class="tablesorter tDados">
            <thead>
                <tr class="ui-widget-header ">
                    <th>Data Contábil          </th>
                    <th>Data Movimento         </th>
                    <th>Horário                </th>
                    <th>Loja                   </th>
                    <th>PDV                    </th>
                    <th>Valor                  </th>
                    <th>Transação              </th>
                    <th>Estado Transação       </th>
                    <th>Status                 </th>
                    <th>Ações                  </th> 
                </tr>
            </thead>
            <tbody class="campos">
                <?php 
                    while ($valores = oci_fetch_assoc($TransacoesCB))
                    {
                        ?>
                        <tr>
                           <td align="left">  <?php echo $valores['CRTDATACONTABIL'];?></td>
                           <td align="center"><?php echo $valores['CRTDATAMOVTO'];?></td>
                           <td align="center"><?php echo $valores['CRTHORARIO'];?></td>
                           <td align="center"><?php echo $valores['CRTLOJA'];?></td>                            
                           <td align="center"><?php echo $valores['CRTPDV'];?></td>                            
                           <td align="right"> <?php echo number_format($valores['CRTVALOR'], 2, '.', '');?></td>  
                           <td align="left">  <?php echo $valores['CRTCODIGOTRANS'].'-'.$valores['CCTDESCRICAO'];?></td>  
                           <td align="left">  <?php echo $valores['CRTESTADOTRANS'].'-'.$valores['CETDESCRICAO'];?></td>  
                           <td align="left">  <?php echo $valores['CRTSTATUS'].'-'.$valores['CSCDESCRICAO'];?></td>  
                            <td class="acoes">
                                <span class="lista_acoes">
                                <ul>
                                    <li class="ui-state-default ui-corner-all" title="Detalhes" ><a 
                                             href="#" onclick="window.open('<?php echo"?router=T0112/detalheCB&CRTLOJA=".$valores['CRTLOJA']."&CRTPDV=".$valores['CRTPDV']."&CRTNSUSITEF=".$valores['CRTNSUSITEF']."&CRTNSUGCB=".$valores['CRTNSUGCB']."&CRTAUTCHAVE=".$valores['CRTAUTCHAVE']."&CRTDATACONTABIL=".$valores['CRTDATACONTABIL']?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=100, LEFT=200, WIDTH=800, HEIGHT=700');"  
                                             class="ui-icon ui-icon-bookmark" >
                                            </a></li>
                                </ul>
                                </span>
                            </td>
                      
                        </tr>
                   <?php 
                       $QtdeTotal   += 1 ;
                       $ValorTotal  += $valores['CRTVALOR'];
                   } ?>
                <tr class="ui-widget-shadow">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="center"><B><h2>Total:</h2></B></td>
                    <td align="center"><B><h2><?php echo $QtdeTotal?></h2></B></td>
                    <td align="right" ><B><h2><?php echo number_format($ValorTotal, 2, ',', '.');?></h2></B></td>                            
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

            </tbody>
	</table>
    
</div>