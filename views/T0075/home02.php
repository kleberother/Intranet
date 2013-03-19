<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 16/01/2012 por Roberta Schimidt                               
 * Descrição: Tela totais Cartão
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/


$user       = $_SESSION['user'];

$connEMP            =  "emporium"                                   ;               
$verificaConexao    =  1                                            ; //se 1 ignora conexao, caso haja erro na conexao com BD do Emporium
$objEMP             =  new models_T0075($connEMP,$verificaConexao)  ;

    $conn             =   "mssql";
    $verificaConexao    =   "";
    $db                 =   "DBO_CRE";
    $objMSSQL = new models_T0075($conn,$verificaConexao,$db);

$conn = "";
$obj = new models_T0075($conn);

$usuarioConfianca = $obj->retornaPerfilConfianca($user);


foreach ($usuarioConfianca as $keyUser => $valueUser) 
    {
    $loginUserC = $valueUser["usuario"];
    }

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

       

   </ul>
    <div id="tabs-1">
        <div id="conteudo">
            <table class="form-inpu-tab">
            <thead>
                 <tr>
                    <th width="8000px"><label>Data </label></th>
                    <th width="8000px"><label>Buscar</label></th>
                    <th width="80000px"><label>Loja</label></th>
                </tr>
        
                    <td>
                       <input  size="9"  type="text" class="data"  name="DataInicial" value="<?php if ($dataini == "--") {echo date("d/m/Y");} else {echo $datainiShow;} ?>" />

                    </td>
                    
                    <td>
                        <select id="aps" name="TipBusca" >
                            <?php $buscaTip = $obj->retornaBuscaCombo($tipBusca);
                            echo $buscaTip;?>
                        </select>
                    </td>   
                    
                    <td>
                        <select  name="loja" >
                        
                         $nLojaPag = $objMSSQL->retornaNomeLojaPag($lojaIn); 
                         
                          
                         <option value="0">Selecione... </option> 
                         
                         
                         <option value="<?php echo $lojaIn?>"><?php echo $nLojaPag;?></option> 
                       
                          
                         
                         <?php 
                             
//retorna valores do combobox Loja
$comboPag = $obj->retornaComboPag();

foreach ($comboPag as $keyComboPag => $valueComboPag)
{   
    //retorna nome das lojas
    $nLojaPag = $objMSSQL->retornaNomeLojaPag($valueComboPag['T006_codigo']);
    
?>
<option value="<?php echo $nLojaPag?>">  <?php echo $nLojaPag." - ".$valueComboPag['T006_nome'];?> </option>
                            
                         
    <?php }?>

                        </select>
                        
                    </td>
                     
                    <td>  <input type="submit" id="btnFiltrar" value="Filtrar" />
            </td>
                </tr>
                        
            </thead>
        </table>
            
        </div>
    </div>
</div>
    