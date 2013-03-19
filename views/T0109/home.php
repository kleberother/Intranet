<?php
////Instancia Classe
$conn   =   "ora";

$objORA         = new models_T0109($conn);

$obj            = new models_T0109();

$user           =   $_SESSION['user'];

$comboLoja      =   $obj->retornarLoja(); 

$perfilUsuario  =   $obj->retornaPerfil($user); //48

$lojaUsuario    =   $obj->retornaLojaUsuario($user); //alnascim

$comboLoja      =   $obj->retornaLojas(); 

$aspas          =   ("'");

$tipo           =   $_POST['tipo'];

$seção          =   $_POST['secao'];

$grupo         =   $_POST['grupo'];

$loja           =   $_POST['loja'];

$porcetagem     =   (" %");




//print_r ($grupo);

if (!empty($_POST))
{
    if ($perfilUsuario[0]==47)
        $loja   =   $_POST['loja'];
    else 
        $loja   =   $lojaUsuario;
  }


//Data Inical
 
  if (!empty($_POST)) {
      $dataInicial  = $_POST['dataI'];
      $dataI  = $obj->retornaDataRMS ($_POST['dataI']);
    }
    
  else
    $dataInicial  = date("d/m/Y",mktime(-1));
    
    
    //Data Final
  if (!empty($_POST)){
    $dataFinal  = $_POST['dataF'];
    $dataF      = $obj->retornaDataRMS ($_POST['dataF']);
  }
   else 
    $dataFinal  = date("d/m/Y",mktime(-1));


$dados          =  $objORA->retornaElegiveis();

$seções          =  $objORA->retornaComboSeção();

$grupos         =  $objORA->retornaComboGrupos($seção);


?>

<!-- Divs com filtros oculta -->

<div class="div-primaria div-filtro">
    <form action="" method="post" class="div-filtro-visivel">
        
        <div class="conteudo-visivel padding-5px-vertical">

            <div class="coluna c06_tipo_h_01">       
                <label class="label">Loja</label>
                
                    <?php if($perfilUsuario[0]==47){?>
                    <select name="loja">
                        <option value="">Todas</option>
                        <?php foreach($comboLoja as $campos => $valores){?>
                            <option value="<?php echo $valores['LojaCodigo']?>"           <?php echo $valores['LojaCodigo']==$loja?"selected":"";?>><?php echo $obj->preencheZero("E", 3, $valores['LojaCodigo'])."-".$valores['LojaNome'];?></option>
                        <?php }?>
                     </select>  
                
                    <?php }else if($perfilUsuario[0]==48){?>
                    <select name="loja" disabled>
                        <?php foreach($comboLoja as $campos => $valores){?>
                            <option value="<?php echo $valores['LojaCodigo']?>"            <?php echo $valores['LojaCodigo']==$lojaUsuario?"selected":""?>><?php echo $valores['LojaCodigo']==$lojaUsuario?$obj->preencheZero("E", 3, $valores['LojaCodigo'])."-".$valores['LojaNome']:" 999 - erro";?></option>
                        <?php }?>
                    </select>                                    
                    <?php }?>
               </div>
            
              <div class="coluna c06_tipo_h_02">       
                <label class="label">Seção</label>
                <select name="secao">
                    <option value="">Todas...</option>
                    <?php while ($row = oci_fetch_assoc($seções)){?>
                    <option value="<?php echo $row['SECAO']?>" <?php echo $row['SECAO']==$seção?"selected":"";?>><?php echo $row['SECAO']?></option>
                    <?php }?>
                </select>
               </div> 
            
            
              <div class="coluna c06_tipo_h_03">       
                <label class="label">Grupo</label>
                <select name="grupo">
                    <option value="">Todos...</option>
                    <?php while ($rows = oci_fetch_assoc($grupos)){?>
                    <option value="<?php echo $rows['GRUPO']?>" <?php echo $rows['GRUPO']==$grupo?"selected":"";?>><?php echo $rows['GRUPO']?></option>
                    <?php }?>
                </select>
               </div>  

    
            <div class="padding-5px-vertical margin-padrao-vertical coluna c06_tipo_h_06">
                <input type="submit" class="botao-padrao" value="Filtrar">
            </div>

       </div> 
      
    </form>              
    
</div>

<div class="div-primaria padding-padrao-vertical">
    
  <div id="conteudo">
    <span class="lista_itens">
	<table class="ui-widget ui-widget-content tablesorter" id="tablesorter">
		<thead>
			<tr class="ui-widget-header ">
                            
				<th width="9%">Item GE</th>
				<th width="9%">Descrição GE</th>
                                <th width="6%">Item</th>
                                <th width="6%">Descrição</th>
                                <th width="6%">R$ Item</th>
                                <th width="6%">Prazo GE</th>
                                <th width="6%">Faixa Inicial</th>
                                <th width="6%">Faixa Final</th>
                                <th width="6%">Prêmio</th>
			</tr>
		</thead>
                
		<tbody> <?php $i=1;?>
                    <?php while ($row_ora = oci_fetch_assoc($dados)){?> 
			<tr class="dados"> 
                            
                                <td><?php echo $row_ora['ITEMGE'];?></td>
                                <td><?php echo $row_ora['DESCGE'];?></td>
			        <td><?php echo $row_ora['ITMNORMAL'];?></td>
                                <td><?php echo $row_ora['DESCNORMAL'];?></td>
                                <td><?php echo money_format("%.2n",$row_ora['PRCITEM']);?></td>
			        <td><?php echo $row_ora['PRAZOGE'];?></td>
                                <td><?php echo money_format("%.2n",$row_ora['FXINICIAL']);?></td>
                                <td><?php echo money_format("%.2n",$row_ora['FXFINAL']);?></td>
			        <td><?php echo money_format("%.2n",$row_ora['PRCPREMIO']);?></td>
                                
                <?php   
                      
                ?>
                                
                        </tr>
                                
                 <?php $i++; }?>
                        
               <tr class="ui-widget-header ">
                   
				<th width="9%">Total</th>
				<th width="9%"></th>
                                <th width="6%"></th>
                                <th width="6%"></th>
                                <th width="6%"></th>
                                <th width="6%"></th>
                                <th width="6%"></th>
                                <th width="6%"></th>
                                <th width="6%"></th>
                                
		</tr>
                
        </li>   
                         
                         
                         
                         
                <!-- Caixa Dialogo Excluir -->
                <div id="dialog-confirm" title="Mensagem!" style="display:none">
                    <p><span class="ui-icon ui-icon-alert" style="float:center; margin:0 7px 20px 0;"></span>Tem certeza que deseja excluir este item?</p>
                </div>
                </tbody>
	</table>
    </span>
</div>
