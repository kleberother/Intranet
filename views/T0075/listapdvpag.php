<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 16/01/2012 por Roberta Schimidt                               
 * Descrição: Tela totais Cartão
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/
// Instancia Classe T0057 para conexao Emporium
$connEMP            =  "emporium"                                   ;               
$verificaConexao    =  1                                            ; //se 1 ignora conexao, caso haja erro na conexao com BD do Emporium
$objEMP             =  new models_T0075($connEMP,$verificaConexao)  ;

$conn               =   "mssql";
$verificaConexao    =   "";
$db                 =   "DBO_CRE";
$objMSSQL = new models_T0075($conn,$verificaConexao,$db);
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
        <li><a href="#tabs-2">Cancelamentos</a></li>
  
        
        
    </ul>
    <div id="tabs-1">
        <div id="conteudo">
    <form action="#tabs-1" method="post">
<?php 
   $dataini = $_GET['DataInicial'];

$datafim = $_GET['DataFinal'];

$loja = $_GET['loja'];
$pdv =  $_GET['pdv'];
    
$mes    = date("m");
$ano    = date("Y");          

         $datainiShow = substr($dataini,8,2)."/".substr($dataini,5,2)."/".substr($dataini,0,4);
        $datafimShow = substr($datafim,8,2)."/".substr($datafim,5,2)."/".substr($datafim,0,4);
?>  
        
    
        <div class="textarea">
            <span id="carregando"></span>
            <span class="loading">Aguarde Carregando...</span>
        </div>
        </form>
</div>
        <div id="conteudo">
    <span class="lista_itens">      
        
        
    
	<table width="80%">
		<thead >
			<tr style="background-color: #d3d3d3" >
                           <th width="2%" style="text-align: center;" >LOJA     </th>
                            <th width="2%" style="text-align: center;">PDV</th>
                             <th width="5%"  style="text-align: center;" >VALOR</th>
                            <th width="10%"  style="text-align: center;" >NOME</th>
                            <th width="10%"  style="text-align: center;" >CPF</th>
                    </tr>
                      
               	
		</thead>
                
                <tbody >
                    <?php
                    
                    $listaPagPdv = $objMSSQL->retornaListarPdvPag($dataini, $datafim, $loja, $pdv);
                    
                    while ( $row = mssql_fetch_array($listaPagPdv)){
                        
                    $valor =  $row['VALOR'];   
                    $valor = number_format($valor, 2,',','');
                      
                   ?>     
                           
                    <tr  >
                            <td width="2%" style="text-align: center;" ><?php echo $row['LOJA']; ?></td>
                            <td width="2%" style="text-align: center; "><?php echo $row['PDV']; ?></td>
                            <td width="5%"  style="text-align: center;"><?php  echo $valor; ?></td>
                            <td width="10%" style="text-align: center; " ><?php echo $row['NOME']; ?></td>
                            <td width="10%" style="text-align: center;" ><?php echo $row['CPF']; ?></td>
                      
                    </tr>
                           
                  <?php }?>
                  
                </tbody>
	</table>
    </span>
        <span class="form-input">
        <div class="form-inpu-botoes">
        </div>   
        </span>    

</div>
    </div>
     <div id="tabs-2">
        <div id="conteudo">
    <form action="#tabs-2" method="post">
<?php 
   $dataini2 = $_GET['DataInicial'];

$datafim2 = $_GET['DataFinal'];

$loja2 = $_GET['loja'];
$pdv2 =  $_GET['pdv'];
    
$mes    = date("m");
$ano    = date("Y");          

         $datainiShow = substr($dataini2,8,2)."/".substr($dataini2,5,2)."/".substr($dataini2,0,4);
        $datafimShow = substr($datafim2,8,2)."/".substr($datafim2,5,2)."/".substr($datafim2,0,4);
?>  
        
    
        <div class="textarea">
            <span id="carregando"></span>
            <span class="loading">Aguarde Carregando...</span>
        </div>
        </form>
</div>
        <div id="conteudo">
    <span class="lista_itens">      
        
        
    
	<table width="80%">
		<thead >
			<tr style="background-color: #d3d3d3" >
                           <th width="2%" style="text-align: center;" >LOJA     </th>
                            <th width="2%" style="text-align: center;">PDV</th>
                             <th width="5%"  style="text-align: center;" >VALOR</th>
                            <th width="10%"  style="text-align: center;" >NOME</th>
                            <th width="10%"  style="text-align: center;" >CPF</th>
                    </tr>
                      
               	
		</thead>
                
                <tbody >
                    <?php
                    
                    $listaPagPdv = $objMSSQL->retornaListaCancelamentoPag($dataini2, $datafim2, $loja2, $pdv2);
                    
                    while ( $row = mssql_fetch_array($listaPagPdv)){
                        
                    $valor =  $row['VALOR'];   
                    $valor = number_format($valor, 2,',','');
                      
                   ?>     
                           
                    <tr  >
                            <td width="2%" style="text-align: center;" ><?php echo $row['LOJA']; ?></td>
                            <td width="2%" style="text-align: center; "><?php echo $row['PDV']; ?></td>
                            <td width="5%"  style="text-align: center;"><?php  echo $valor; ?></td>
                            <td width="10%" style="text-align: center; " ><?php echo $row['NOME']; ?></td>
                            <td width="10%" style="text-align: center;" ><?php echo $row['CPF']; ?></td>
                      
                    </tr>
                           
                  <?php }?>
                  
                </tbody>
	</table>
    </span>
        <span class="form-input">
        <div class="form-inpu-botoes">
        </div>   
        </span>    

</div>
    </div>
</div>