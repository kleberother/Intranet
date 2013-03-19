<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$seg = $_POST['tipo'];
$datainiS = $_POST["DataInicialS"];
$datainiS = substr($datainiS,6,4)."-".substr($datainiS,3,2)."-".substr($datainiS,0,2);
$datafimS = $_POST["DataFinalS"];
$datafimS = substr($datafimS,6,4)."-".substr($datafimS,3,2)."-".substr($datafimS,0,2);

$RankingSeguro = $obj->retornaSeguro($seg, $datainiS, $datafimS);
    

    
$mes= date("m");
$ano = date("Y");
    
?>


<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0055/home" class="active">Rankings</a></li>
                <li><a href="?router=T0055/manu" >Manutenção</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="tabs">
    <ul>
        <li><a href="home.php">Cartão</a></li>
        <li><a href="#tabs-2">Seguros</a></li>
        
    </ul>
</div>


<div id="tabs-2">
        <div id="conteudo">
    <form action="" method="post">
        <table class="form-inpu-tab">
            <thead>
                
                 <tr>
                    <th width="1000px"><label>Tipo</label></th>
                    <th width="1000px"><label>Data Inicial</label></th>
                    <th width="8000px"><label>Data Final</label></th>
                                      
                    
                </tr>
                <tr>
                <td>
                        <select id="aps" name="tipo">
                            <option value="0">Selecione...         </option>
                            <option value="1">Perda e Roubo    </option>
                            <option value="2">Desemprego</option>
                         
                        </select>
                        
                    </td>
              
                    <td>
                       <input  size="6"  type="text" id="dt_inicialS"  name="DataInicialS" value="<?php echo "01/".$mes."/".$ano; ?>" />

                    </td>
                    <td>
                        <input size="6"  type="text" id="dt_finalS"   name="DataFinalS" value="<?php echo date("d/m/Y");?>"/>
                    </td>                    
                    
                </tr>
                        
            </thead>
        </table>
        <span class="form-input">
        <div class="form-inpu-botoes">
            <input type="submit" id="btnFiltrar" value="Filtrar"/>
            
        </div>   
        </span>
        <div class="textarea">
            <span id="carregando"></span>
            <span class="loading">Aguarde Carregando...</span>
        </div>
        </form>
</div>
        <div id="conteudo">
    <span class="lista_itens">
	<table>
		<thead>
			<tr class="ui-widget-header ">
                       
                            <th width="5%">Loja               </th>
                            <th width="5%">Realizado    </th>
                            <th width="5%" >Meta        </th>
                            <th width="5%">Projeção               </th>
                            
			</tr>
		</thead>
                <tbody class="campos">
                    <?php
                    
                    
                     
                    while ($row = mssql_fetch_array($RankingSeguro)){
                       
                        $loja = $row['LOCAL'];
                        
                        $nloja = $obj->retornaNomeLoja($loja);
                        
                        ?>
                    <tr>
                        <td><?php echo $row['LOCAL']." - ".$nloja;?></td>
                        <td><?php echo $row['CAPTADOS']?></td>
                        <td><?php echo $row['META_CARTAO']?></td>
                        <td></td>
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