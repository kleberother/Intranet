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
$SelectBoxStatus     =   $objORA->retornaStatusConciliacoes ();
$SelectBoxTransacoes =   $objORA->retornaTiposTransacoes ();
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

    
    
    // carrega transacacoes somente se foi clicado no botao Filtrar
    $ResumoCB = $objORA->retornaResumoTransacoesCB ($loja,$status,$codTransacao,$dataCI,$dataCF,$dataMI,$dataMF);    
    $ResumoBB = $objORA->retornaResumoEspelhoBB    ($loja,$status,$codTransacao,$dataCI,$dataCF,$dataMI,$dataMF);    
    
    $QtdeTotal  = 0 ;
    $ValorTotal = 0 ;
}


?>

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="#"                     class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-filter"  ></span>Filtros </a></li>
        <li><a style="color:red;" href="<?php echo ROUTER."home";?>"            class="botao-padrao"><span class="ui-icon ui-icon-image"  ></span>Resumo</a></li>
        <li><a href="<?php echo ROUTER."espelhoBB";?>"       class="botao-padrao"><span class="ui-icon ui-icon-document-b"  ></span>Espelho BB</a></li>
        <li><a href="<?php echo ROUTER."transacoesCB";?>"    class="botao-padrao"><span class="ui-icon ui-icon-note"  ></span>Transações CB</a></li>
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
        <?php 
            while ($valores = oci_fetch_assoc($SelectBoxStatus))
            { ?>
                <option value="<?php echo $valores['CSCCODIGO']?>"<?php echo $status==$valores['CSCCODIGO']?"selected":"";?>><?php echo $obj->preencheZero("E",3,$valores['CSCCODIGO'])."-".$valores['CSCDESCRICAO'];?></option>
       <?php 
            } ?>    
        </select>
    </div>    
    <div class="grid_3">
        <label class="label">Data Contabil Ini.</label>
        <input type="text" name="dataCI" class="data" value="<?php echo $dataCI;?>" />
    </div>
    <div class="grid_3">        
        <label class="label">Data Contabil Fin.</label>
        <input type="text" name="dataCF" class="data" value="<?php echo $dataCF;?>" />
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
    
    <div class="grid_24">
         <h2>Espelho Banco do Brasil</h2>
    </div>
    <div class="clear10"></div>    
	<table class="tablesorter tDados">
            <thead>
                <tr class="ui-widget-header ">
                    <th>Data Contábil          </th>
                    <th>Status                 </th>
                    <th>Quantidade             </th>
                    <th>Valor                  </th>
                </tr>
            </thead>
            <tbody class="campos">
                <tr>
                    <td align="center">
                        
                    </td>
                </tr>
                <?php 
                    while ($valores = oci_fetch_assoc($ResumoBB))
                    {

                        ?>
                        <tr>
                           <td align="left">  <?php echo $valores['DATACONTABIL'];?></td>
                           <td align="left"> <?php echo $valores['STATUS'];?></td>
                           <td align="right"><?php echo $valores['QTDE'];?></td>
                           <td align="right"><?php echo number_format($valores['VALOR'], 2, ',', '.');?></td>                            
                           
                        </tr>
                   <?php 
                      $QtdeTotal   += $valores['QTDE'];
                      $ValorTotal  += $valores['VALOR'];
                   
                   } ?>
                        <tr class="ui-widget-shadow">
                            <td align="left"><B><h2></h2></B></td>
                            <td align="right"><B><h2>Total:</h2></B></td>
                            <td align="right"><B><h2><?php echo $QtdeTotal?></h2></B></td>
                            <td align="right"><B><h2><?php echo number_format($ValorTotal, 2, ',', '.');?></h2></B></td>                            
                        </tr>
            </tbody>
	</table>
        <?php
            // Zera as variaveis de totalizador
            $QtdeTotal  = 0 ;
            $ValorTotal = 0 ;
        ?>
    <div class="clear10"></div> 
    <div class="grid_24">
         <h2>Transações Correspondente Bancário</h2>
    </div>
    <div class="clear10"></div>    
	<table class="tablesorter tDados">
            <thead>
                <tr class="ui-widget-header ">
                    <th>Data Contábil          </th>
                    <th>Status                 </th>
                    <th>Quantidade             </th>
                    <th>Valor                  </th>
                </tr>
            </thead>
            <tbody class="campos">
                <tr>
                    <td align="center">
                        
                    </td>
                </tr>
                <?php 
                    while ($valores = oci_fetch_assoc($ResumoCB))
                    {

                        ?>
                        <tr>
                           <td align="left">  <?php echo $valores['DATACONTABIL'];?></td>
                           <td align="left"> <?php echo $valores['STATUS'];?></td>
                           <td align="right"><?php echo $valores['QTDE'];?></td>
                           <td align="right"><?php echo number_format($valores['VALOR'], 2, ',', '.');?></td>                            
                         
                        </tr>
                   <?php  
                      $QtdeTotal   += $valores['QTDE'];
                      $ValorTotal  += $valores['VALOR'];
                   
                   } ?>
                        <tr class="ui-widget-shadow">
                            <td align="left"><B><h2></h2></B></td>
                            <td align="right"><B><h2>Total:</h2></B></td>
                            <td align="right"><B><h2><?php echo $QtdeTotal?></h2></B></td>
                            <td align="right"><B><h2><?php echo number_format($ValorTotal, 2, ',', '.');?></h2></B></td>                            
                        </tr>
                        
            </tbody>
	</table>
    
</div>
