<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 01/11/2012 por Roberta Schimidt                               
 * Descrição: Ranking Comissão 
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/

$conn = "";
$obj = new models_T0114($conn);


?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0114/home" >Comissões</a></li>
                <li><a href="?router=T0114/home" class="active" >Angenciados</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Cadastro</a></li>
   </ul>
            <div id="tabs-1">
 <?php  
 
if ($_POST["T109_Nome"] <> ""){
    
    $_POST["T109_Cpf"] = str_replace(".", "", $_POST["T109_Cpf"]);
    
    
    $ultimaMatricula = $obj->retornaUltimaMatricula($_POST["T109_Loja"]);
    
    foreach($ultimaMatricula as $key => $value){
        
        $matriculaAgencia = ($value["UltimaMatricula"] + 1);
        
    }
    
   
    $campos =   array("T109_Loja"               =>  $_POST["T109_Loja"]
                     ,"T109_Matricula"          =>  $matriculaAgencia
                     ,"T109_MatriculaAgencia"   =>  $matriculaAgencia
                     ,"T109_Nome"               =>  $_POST["T109_Nome"]
                     ,"T109_Funcao"             =>  "Aprendiz"
                     ,"T109_Cpf"                =>  $_POST["T109_Cpf"]
                     ,"T109_Situacao"           =>  "ATIVO");
    
    $tabela = "T109_func_confianca";
    
     $obj->inserir($tabela, $campos);        
    
            
    
} 
              ?>

    <div id="conteudo">
        <form action="#tabs-1" method="post">
            <table class="form-inpu-tab">
                <thead>
                 <tr>
                    <th width="8000px"><label>Nome </label></th>
                    <th width="8000px"><label>CPF</label></th>
                    <th width="80000px"><label>Loja</label></th>
                    <th width="80000px"></th>
                    
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" size="30" name="T109_Nome"/></td>
                    <td><input type="text"  name="T109_Cpf"/></td>
                    <td>
                        <select  name="T109_Loja" >
                         <?php 
                         $nLoja = $obj->retornaNumLoja($lojaIn); 
                        $BuscaLoja = $obj->retornaBuscaComboLoja($lojaIn);
                        echo $BuscaLoja;
                         ?>
                        <?php 
                             //}
//retorna valores do combobox Loja
$comboLoja = $obj->retornaLoja();

foreach ($comboLoja as $keyComboLoja => $valueComboLoja)
{   
    //retorna nome das lojas
    $nLoja = $obj->retornaNumLoja($valueComboLoja['T006_codigo']);
    
?>
<option value="<?php echo $nLoja?>">  <?php echo $nLoja." - ".$valueComboLoja['T006_nome'];?> </option>
                            
                         
    <?php }?></select>
                        
                    </td>
                      <td>  <input type="submit" id="btnFiltrar" value="Gravar" onclick="document.getElementById('carregando').style.display='inline'"/>
            </td>
                </tr>
            </tbody>
            </table>
            
        </form>
    </div>
    </div>
</div>