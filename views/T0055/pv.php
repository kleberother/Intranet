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
$data = date("Y-m-d");

  $pv = $obj->retornaPV();
  
  foreach ($pv as $key => $value) {
      
      $dataPv = $value['T084_data'];
    
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

<div id="tabs">
    <ul>
        <li><a href="#tabs-1">PV</a></li>
       
        
    </ul>
    <div id="tabs-1">
        <div id="conteudo">
   
            <form action="#valores" method="post">
        
        <?php 
        
  
        
        
        if($dataPv != $data) {
        ?>
        
        <input type="hidden" name="gerar" value="sim"/>
    <input type="submit" name="btPv" value="Gerar Valores Pv" />
        <?php } else { echo "Valores do Pv já foram atualizados!";} ?>
    </form>
        </div>
    </div>

    <div id="valores">
<?php

$gerar = $_POST["gerar"];


if($gerar == "sim"){    

$retornaPv = $objMSSQL->selecionaPv($data);

while ($row = mssql_fetch_array($retornaPv)){
 
 $dataIn = date("d/m/Y");   
 $tipo = "2";   
 

 
 $campos = array("T084_pv" => $row["QUANTIDADE"]
                    ,"T084_data " => $dataIn
                    ,"T084_tipo" => $tipo
                    ,"T084_loja" => $row["LOCAL"]);
 
 $tabela = "T084_pv_seguro";
 
 $obj->inserir($tabela, $campos);
 header("Location: ?router=T0055/pv ");
}
}
       
              ?>
    
    </div></div>