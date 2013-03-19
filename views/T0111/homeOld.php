<?php

///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 17/07/2012 por Roberta Schimidt                               
// * Descrição: Ajustes EM$
// * Entrada:   
// * Origens:   
//           
//**************************************************************************

$conn = "";
$obj = new models_T0111();


$ListLoja = $obj->listaLojas("0");

//
//if (!empty($_POST))
//{
//    
//    
//    $filtros            =   " ";
//    
//    $FiltroCpf          = $_POST['CPF'];
//    
//    $FiltroLoja         =  $_POST['loja'];
//    
//    $status             =   $_POST['status'];
//    
//    if (!empty ($FiltroLoja))
//        $filtros    .=  " AND TF1.T006_codigo = $FiltroLoja";
//    if (!empty ($FiltroCpf))
//        $filtros    .=  " AND TF1.T106_codigo = $FiltroForn";  
//    
//    
//    
//    
//        switch ($status) {
//        case 1:
//            $retornaAjustes   =   $obj->retornaAguardandoMinhaConfirmacao($_SESSION['user'],$filtros);
//            break;
//        case 2:
//            $retornaAjustes   =   $obj->retornaMinhasDigitadas($_SESSION['user'],$filtros);
//            break;
//        case 3:
//            $retornaAjustes   =   $obj->retornaAnteriores($_SESSION['user'],$filtros);
//            break;
//        case 4:
//            $retornaAjustes   =   $obj->retornaPosteriores($_SESSION['user'],$filtros);
//            break;
//        case 5:
//            $retornaAjustes   =   $obj->retornaFinalizadas($_SESSION['user'],$filtros);
//            break;
//        case 6:
//            $retornaAjustes   =   $obj->retornaCanceladas($_SESSION['user'],$filtros);
//            break; 
//    }
//}

 
        
        $data = $_POST["dataOper"];
        $cpf = $_POST["cpf_cli"];
        $loja = $_POST["loja_oper"];
        $dataInc = $_POST["dataInc"];
        

?>

<div id="modal">
    <div id="dialog-aprovar" title="Mensagem!" style="display:none">
        <div class='padding-2px-vertical conteudo-visivel'>
            <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja aprovar esse(s) Ajuste(s)?</p>
        </div>
    </div>
</div>


<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0111/home"  class="active">Listar</a></li>
                <li><a href="?router=T0111/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Ajustes</a></li>
</div>
<div id="conteudo">
 <div id="tabs-1">
        
    <form action="#tabs-1" method="post">
        
       
        
        
         <table class="form-inpu-tab">
            <thead>
                 <tr>
                    <th width="8000px"><label>Status do Ajuste </label></th>
                    <th width="8000px"><label>Data da Inclusão </label></th>
                    <th width="8000px"><label>Data da Operação </label></th>
                    
                </tr>
                <tr>
                    <td>  <select name="status">
                    <option value="0" <?php echo $status==0?"selected":""?>>Selecione...                        </option>
                    <option value="1" <?php echo $status==1?"selected":""?>>Aguardando Minha Confirmação        </option>
                    <option value="2" <?php echo $status==2?"selected":""?>>Minhas Digitadas (não confirmadas)  </option>
                    <option value="3" <?php echo $status==3?"selected":""?>>Anteriores a Mim                    </option>
                    <option value="4" <?php echo $status==4?"selected":""?>>Posteriores a Mim                   </option>
                    <option value="5" <?php echo $status==5?"selected":""?>>Finalizadas                         </option>
                    <option value="6" <?php echo $status==6?"selected":""?>>Canceladas                          </option>
                </select></td>
                    <td><input type="text" class="data" name="dataInc"/> </td>
                    <td><input type="text" class="data" name="dataOper"/> </td>
                </tr>
                <tr>
                    <th width="8000px"><label>CPF do Cliente</label></th>
                    <th width="80000px"><label>Loja</label></th>
                </tr>
                <tr>
                    <td><input type="text" class="cpf" name="cpf_cli"/> </td>
                    <td><select name="loja_oper" id="loja" class="validate[required] form-input-text-table loja">
                        <option value="">Selecione...</option>
                    <?php foreach($ListLoja as $campos=>$valores){ ?>
                        <option value='<?php echo $valores['LCODI']; ?>'><?php echo ($valores['LNOME']); ?></option>
                    <?php }?>
                    </select></td>
                   <td>  <input type="submit" id="btnFiltrar" value="Filtrar" onclick="document.getElementById('carregando').style.display='inline'"/>
            </td>
                </tr>
            </thead>
         </table>
        
    </form></div>
         <span class="lista_itens">  
             <table width="80%">
		<thead >
			<tr style="background-color: #d3d3d3" >
                            <th width="3%" style="text-align: center;" >Loja   </th>
                            <th width="3%" style="text-align: center;" >Data da Operação     </th>
                            <th width="9%" style="text-align: center;">Conta</th>
                            <th width="12%"  style="text-align: center;">CPF</th>
                            <th width="3%"  style="text-align: center;">Tipo</th>
                            <th width="5%" style="text-align: center;" >À vista </th>
                            <th width="3%" style="text-align: center;" > Qtd Parc   </th>
                            <th width="5%" style="text-align: center;"  > Valor da Parcela    </th>
                            <th width="3%" style="text-align: center;"  > Total   </th>
                            <th width="3%" style="text-align: center;"  > Cupom   </th>
                            <th width="5%" style="text-align: center;"  > PDV    </th>
                            <th width="15%" style="text-align: center;"  > Motivo   </th>
                            <th width="5%" style="text-align: center;"  >Status   </th>
                            <th width="5%" style="text-align: center;"  > Ações         </th>
                          </tr>
                </thead>
               <tbody >
                   <?php 
                   
              $data = substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
              $dataInc = substr($dataInc,6,4)."-".substr($dataInc,3,2)."-".substr($dataInc,0,2);
                   $dados =  $obj->retornaAjustes($data, $cpf, $loja, $dataInc);
                            foreach($dados as $campos=>$valores){
                                
                $dataRet = $valores["DATA"];  
            $dataRet = substr($dataRet,8,2)."/".substr($dataRet,5,2)."/".substr($dataRet,0,4);
            $dataIncR = $valores["DATA_LAN"];
            $dataIncR = substr($dataIncR,8,2)."/".substr($dataIncR,5,2)."/".substr($dataIncR,0,4);
            
                                $status = $obj->retornaStatus($valores["STATUS"], $valores["COD"]);
                                $nLoja = $obj->numeroLoja($valores["LOJA"]);
                                
                   ?>
                   <tr>
                       <td align="center"><?php echo $nLoja;?></td>
                       <td><?php echo $dataRet."<br> (incluído dia:".$dataIncR.")";?></td>
                       <td><?php echo $valores["CONTA"];?></td>
                       <td><?php echo $valores["CPF"];?></td>
                       <td><?php echo $valores["OPER"];?></td>
                       <td><?php echo str_replace(".", ",",$valores["V_VISTA"] );?></td>
                       <td align="center"><?php echo str_replace(".", ",", $valores["QTD_PARCE"]);?></td>
                       <td><?php echo str_replace(".", ",", $valores["V_PARCE"]) ;?></td>
                       <td align ="center"><?php echo str_replace(".", ",", $valores["V_TOTAL"]) ;?></td>
                       <td><?php echo $valores["CUPOM"];?></td>
                       <td><?php echo $valores["PDV"];?></td>
                       <td><?php echo $valores["MOTIVO"];?></td>
                       <td><?php
                        if ($valores["STATUS"] == 0)
                        {                        
                        ?>
                            <ul class="lista-de-acoes">
                        <li><a href="#" title="Aprovar" class="Aprovar" ><span class='ui-icon ui-icon-check'></span></a></li> </ul>
                        <?php
                        }
                        ?></td>
                       <td>
               <a class="ui-icon ui-icon-search" href="?router=T0111/detalhes&cod=<?php echo $valores["COD"]?>"></a></td>
                       
                   </tr>
               </tbody>
               <?php } ?>
             </table>
         </span></div>
        
 