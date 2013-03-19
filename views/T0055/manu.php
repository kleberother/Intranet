<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 01/12/2011 por Roberta Schimidt                              
 * Descrição: Tela Manutenção de Rankings Cartão
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/
 
$conn               =   "";
$obj = new models_T0055($conn);

$connMSSQL               =   "mssql";
$verificaConexao    =   "";
$db                 =   "DBO_CRE";
$objMSSQL = new models_T0055($connMSSQL,$verificaConexao,$db);


$Lojas = $objMSSQL->retornaLoja();

$lojas  =   $_POST['loja']      ; 
$perdaeroubo  =   $_POST['perda']      ;
$desemprego = $_POST['desemprego'];
$ativados = $_POST['ativados'];
$adicionais = $_POST['adicionais'];
$aprovados = $_POST['aprovados'];




//loop para inserir ano , mês e tipo para cada meta.
for ($x = 0; $x<=8 ; $x++)
  
{
  
  $meses[$x] =  $_POST["mes"] ;  
  $anos[$x]  =  $_POST["ano"] ;
  
    
}




$tabela =   "T082_metas";



if(!empty($_POST))
{

    
    for ($i = 0; $i <= 8; $i++) 
    {
       
            $campos  =   array( "T082_mes" => $meses[$i]
                         ,  "T082_ano"  => $anos[$i]
                         ,  "T082_loja" => $lojas[$i]
                         ,  "T082_perda_e_roubo" => $perdaeroubo[$i]
                         ,  "T082_desemprego" => $desemprego[$i]
                         ,  "T082_ativados" => $ativados[$i]
                         ,  "T082_adicionais" => $adicionais[$i]
                         ,  "T082_aprovados" => $aprovados[$i]
                         
                
                     );

            
            
      $obj->inserir($tabela, $campos);
      
     
      header('location');
    }
}

?>


<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0055/home" >Rankings</a></li>
                <li><a href="?router=T0055/manu" class="active">Manutenção</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Metas</a></li>
        <li><a href="#tabs-2">Projeção</a></li>
         
     </ul>
    <div id="tabs-1">
  <div id="formulario" class="formulario">

    <span class="form-input">
        
        <form action="" method="post">
       

        <table  >
            
            <tr>     
                        
                        <td>
                    &nbsp;
                </td>
            
                
                <?php 

?>
                <td style="width: 10px;">Mês: <select  name="mes">
                            <option value="0">Selecione...         </option>
                            <option value="01">Janeiro    </option>
                            <option value="02">Fevereiro</option>
                            <option value="03">Março</option>
                            <option value="04">Abril</option>
                            <option value="05">Maio</option>
                            <option value="06">Junho</option>
                            <option value="07">Julho</option>
                            <option value="08">Agosto</option>
                            <option value="09">Setembro</option>
                            <option value="10">Outubro</option>
                            <option value="11">Novembro</option>
                            <option value="12">Dezembro</option>
                         
                        </select> </td>
                        
                          <td>
                     &nbsp;
                </td>
                
                <td>Ano: <input type="text" name="ano"  size="6" /></td>
            
            </tr>
            <tr><td>
                    &nbsp;
                </td></tr>
            
            <tr>
                <td style="width: 5px">Loja</td>
                <td>
                    &nbsp;
                </td>
                <td style="width: 5px">Perda/Roubo</td>
                <td style="width: 5px">Desemprego</td>
                <td style="width: 5px">Ativados</td>
                <td style="width: 5px">Adicionais</td>
               <td style="width: 5px">Aprovados</td>
               
               
                
                
                
            </tr>
            
                 <tr><td>
                    &nbsp;
                </td></tr>
            
   
          <?PHP
              
          
          while($row = mssql_fetch_array($Lojas)){
          
          ?>
            
 
            
            <tr>
                <td><?php echo $row['COD_LOCAL']." - ".$row['DSC_LOCAL']; ?></td>
                
                <input type="hidden" name="loja[]" value="<?PHP ECHO $row['COD_LOCAL']; ?>" />
                <td>
                    &nbsp;
                </td>
                
                <td><input type="text" name="perda[]"   size="7"     /></td>
                <td><input type="text" name="desemprego[]"   size="7"     /></td>
                <td><input type="text" name="ativados[]"   size="7"     /></td>
                <td><input type="text" name="adicionais[]"   size="7"    /></td>
                <td><input type="text" name="aprovados[]"   size="7"     /></td>
               
               
                <tr>     <td>
                    &nbsp;
                </td></tr>
                
                
                
              
               
               
                
            </tr>
         <?php }  
$MetaMes = $obj->retornaAllMeta();

foreach ($MetaMes as $campos => $valores){
    
    $mesMeta = $valores['T082_mes'];
   }
   
   $mesAtual = date("m");
   
   if ($mesAtual == $mesMeta){
   
       echo $mesAtual;
?>
          <tr>        <td>
                           Metas do mês já inseridas!
                    </td></tr>
        
        <?php } else {?>
        
            <tr>        <td>
                           <input type="submit" id="btnFiltrar" value="Salvar"/> 
                    </td></tr>
            
            <?php }?>
        </table>
        
        
        
        </form>
</div>

</div>



    <div id="tabs-2">
  
        
        <?php
        
        $projecao = $_POST['T083_projecao'];
        $mes = $_POST['T083_mes'];
        $ano = $_POST['T083_ano'];
        
        
        $tabela = "T083_projecao";
        
       $campos = array(
           
           "T083_projecao" => $projecao
          ,"T083_mes" => $mes
          ,"T083_ano" => $ano
           
       );
        
        
        $obj->inserir($tabela, $campos);
        header('Location');
        
        ?>
        
        
        
        <div id="formulario" class="formulario">

      
      
      
    <span class="form-input">
        
        <form action="#tabs-2" method="post">
    
            
            
            

        <table  >
            
 
         
            
            <tr>
       
                <td style="width: 1px">Projeção</td>
                <td>&nbsp;</td>
                 <td style="width: 1px">Mês</td>
                <td>&nbsp;</td>
                
                <td style="width: 1px" >Ano</td>
               
                
                
                
            </tr>
            
                 <tr><td>
                    &nbsp;
                </td></tr>
            
   
          <?PHP
              
$mes= date("m");
$ano = date("Y");
          
          //while($row = mssql_fetch_array($Lojas)){
          
          ?>
            
 
            
      <tr>
               
                <td style="width:1px "><input type="text" name="T083_projecao"   size="10"  value=""   /></td>
                 <td>&nbsp;</td>
               <td style="width: 10px;"><select  name="T083_mes">
                            <option value="0">Selecione...         </option>
                            <option value="01">Janeiro    </option>
                            <option value="02">Fevereiro</option>
                            <option value="03">Março</option>
                            <option value="04">Abril</option>
                            <option value="05">Maio</option>
                            <option value="06">Junho</option>
                            <option value="07">Julho</option>
                            <option value="08">Agosto</option>
                            <option value="09">Setembro</option>
                            <option value="10">Outubro</option>
                            <option value="11">Novembro</option>
                            <option value="12">Dezembro</option>
                         
                        </select> </td>
                 <td>&nbsp;</td>
                <td style="width:1px "><input type="text" name="T083_ano"  size="9" value="<?php echo $ano; ?>"/></td>
      
                <td>&nbsp;</td>
                
                
            <td>
                           <input type="submit" id="btnFiltrar" value="Enviar"/> 
                    </td></tr>
        
        </table>
        
        
        
        </form>
</div>

</div>
    
    
    
    
    
    
</div>
    
   