<?php

/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 02/02/2012 por Roberta Schimidt                               
 * Descrição: Tela Observações de Vendas e Pagamentos
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/
//conexao mysql

$conn = "";
$obj = new models_T0075($conn);

//conexao mssql
//
$connMSSQL = "mssql";
$verificaConexao = "";
$db = "DBO_CRE";
$objMSSQL = new models_T0075($connMSSQL, $verificaConexao, $db);

$loja = $_GET['loja'];
$pdv = $_GET['pdv'];
$data = $_GET['data'];
$final = $_GET['final'];



$dataObs = $_POST['dataObs'];
$dataObs= substr($dataObs,8,2)."/".substr($dataObs,5,2)."/".substr($dataObs,0,4);
$pdvObs = $_POST['pdvObs'];
$Obs = $_POST['Obs'];
$lojaObs = $_POST['lojaObs'];
$finalObs = $_POST['finalObs'];
$codigoObs = $_POST['codObs'];
$tipo_aj = $_POST['tipo_aj'];


if($tipo_aj == "1"){

$valor_ajus = $obj->formataReais($_POST["valor_ajus"], $_POST["valor_old"], "-");}

else {
 
    $valor_ajus = $obj->formataReais($_POST["valor_old"], $_POST["valor_ajus"], "+");   
    
}



$opcao = $_POST["opcao"];


if($opcao == "excluir"){
    
    $comando = "excluir";

} else {
    
    $comando = $_POST["comando"];
   
}

if ($Obs != ""){
    
    $campos = array(  "T090_observacao" => $Obs
                    , "T090_data" => $dataObs
                    , "T090_pdv" => $pdvObs
                    , "T090_loja" => $lojaObs
                    , "T090_finalizadora" => $finalObs
                    , "T090_tipo_op" => $tipo_aj
                    , "T090_valor" => $valor_ajus);
    
    
    
    $tabela = "T090_obs_totais";
    $delim = " T090_codigo =". $codigoObs;
    
    if ($comando == "salvar"){
        
        $obj->inserir($tabela, $campos);
    } 
    elseif ($comando == "atualizar"){
        
        $obj->altera($tabela, $campos, $delim);
        
       
    } else {
        
        $obj->excluir($tabela, $delim);
    }

    
}
               
                 $retornaObs  = $obj->retornaObs($pdv, $loja, $final, $data);
                 
                 foreach($retornaObs as $camposRet => $valoresRet){
                     
                 $obsRet = $valoresRet["T090_observacao"];
                 $codRet = $valoresRet["T090_codigo"];
                 $ajuste = $valoresRet["T090_valor"];
                 $tipo_op = $valoresRet["T090_tipo_op"];
                     
                 }
                 
                 $ajuste = $obj->totalValores($ajuste);

?>


<div id="ferramenta">
    <div id="ferr-conteudo">    
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0075/home" class="active">Observação</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Ajustes</a></li>
        
    </ul>
    <div id="tabs-1">
        <div id="conteudo">
    <form action="#tabs-1" method="post">
        
        <table>
            <thead>
                <tr>
                    <th width="0px">Loja:</th>
                    <th width="100px" >PDV: </th>
                    <th width="100px" > Inclusão</th>
                    <th width="100px" > Estorno</th>
                    <th width="10px" align="center" >Valor:</th>
                    
                </tr>
                <tr>
                    <td width="0px" style=" text-align: center;"> <?php echo $loja; ?></td>
                    <td width="100px" style=" text-align: center;"><?php echo $pdv;?></td>
                    <td width="100px"  align="center"><input type ="radio" name="tipo_aj" value="2" <?php if ($tipo_op == "2" ) {?> checked <?php }?>/></td>
                    <td width="100px" align ="center"><input type ="radio" name="tipo_aj" value="1" <?php if ($tipo_op == "1"){?> checked <?php }?>/></td>  
                    <td width="100px" align ="center"><input type ="text" size="8" name="valor_ajus" value="<?php echo $ajuste;?>"/></td>  
                    <td width="100px" align ="center"><input type ="hidden" size="8" name="valor_old" value="<?php echo $ajuste;?>"/></td>  
                     
                </tr> 
                <tr>
                    <td><br><br></td>
                </tr>
            </thead>
        </table>
        <table>
            <thead>
            
                 <tr>
                     <td><textarea cols="90" rows="10" name="Obs" ><?php echo $obsRet; ?></textarea>
                         <input type="hidden" value="<?php echo $loja;?>" name="lojaObs"/>
                         <input type="hidden" value="<?php echo $pdv;?>" name="pdvObs"/>
                         <input type="hidden" value="<?php echo $data;?>" name="dataObs" />
                         <input type="hidden" value="<?php echo $final;?>" name="finalObs" />
                         <input type="hidden" value="<?php echo $codRet;?>" name="codObs" />
                         <input type="hidden" value="<?php if($obsRet == ""){ echo "salvar" ;} else {echo "atualizar"; };?>" name="comando" /></td>
                    <td>&nbsp;</td>
                    <td style="vertical-align: bottom; " ><?php if ($obsRet == ""){?><input type="submit"  value="Enviar"/></td><?php } else {?><td width="100px" style="vertical-align: bottom; " ><label>Excluir</label><input type="checkbox" value="excluir" name="opcao" /></td><td style="vertical-align: bottom; " ><input type="submit"  value="Salvar"/><?php }?></td>
                 </tr> 
            </thead>
        </table>
    
    
    </form>
        </div> 
    </div> 
</div>
