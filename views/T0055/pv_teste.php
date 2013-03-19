<?php

/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 05/01/2012 por Roberta Schimidt                               
 * Descrição: Processo de inclusão de PV 
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/

//conexao mysql

$conn = "";
$obj = new models_T0055($conn);

//conexao mssql
//
$connMSSQL = "mssql";
$verificaConexao = "";
$db = "DBO_CRE";
$objMSSQL = new models_T0055($connMSSQL, $verificaConexao, $db);

$atualizar = $_POST["atualiza"];

$dataAtual = date("Y-m-d");

//$dataAtual = "2012-01-06";



//Select que verifica se há dados inseridos na data atual
$pvDiario = $obj->retornaPV();


 
 

foreach($pvDiario as $campos=>$valores)

    {
    
    
   
    
    $dataPv =  $valores["T084_data"];
    
    }
    

    
      ?>

 
        

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0055/home" >Rankings</a></li>
                <li><a href="?router=T0055/manu" >Manutenção</a></li>
                 <li><a href="?router=T0055/pv" class="active" >PV</a></li>
                
            </ul>
        </span>
    </div>
</div>
<div id="conteudo">
    <div id="tabs">
    <ul>
        <li><a href="#tabs-1">Pv</a></li>
      </ul>
        <br>
        
    <form action="" method="post">
        
   <?php         if ($dataPv == $dataAtual)
    {
    
       echo "Já foram registrados valores PV para esta data<br><br>";    
    
    
    }  else {
    ?>
  
        <input type="text" name="atualiza" value="sim"/>
        
         <input type="submit" id="btnFiltrar" value="Atualizar PV"/><br>
         
        
    </form>  


        <?php  
    }
    
     
       // seleciona os valores do PV da data atual 
    



        
   if ($atualizar == "sim")
{
        
    $pvDiario =  $objMSSQL->selecionaPv($dataAtual);
      
       while ($row = mssql_fetch_array($pvDiario));
       {
      
         $pv = $row['quantidade'];
         $loja = $row['LOCAL'];
         $tipo = '2';
         
         $dataAtual = date("d/m/Y");

         $array = array( "T084_pv" => $pv
                     ,  "T084_data" =>$dataAtual
                     ,  "T084_tipo" =>$tipo
                     ,  "T084_loja" =>$loja
                            );  
               
               $tabela = "T084_pv_seguro";
           //insere valores do pv na tabela do BD Satelite    
                 $obj->inserir($tabela, $array);
      header('Location: ?router=T0055/pv');
          
      
       } } 


        
?>
</div>
</div>