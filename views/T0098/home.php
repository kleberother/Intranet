<?php
////Instancia Classe

$conn   =   "ora";
$objORA    =   new models_T0098($conn);

$obj       =   new models_T0098();
$user           =   $_SESSION['user'];

$perfilUsuario  =   $obj->retornaPerfil($user); //48

$lojaUsuario    =   $obj->retornaLojaUsuario($user); //alnascim

$comboLoja      =   $obj->retornaLojas();    

if (!empty($_POST))
{
    $conferido  =   $_POST['conferido'];
    
    if ($perfilUsuario[0]==47)
        $loja   =   $_POST['loja'];
    else 
        $loja   =   $lojaUsuario;
    
    
    //Data Inical
    $dataInicial    =   $_POST['dataI'];
    $arrayData      = explode("/", $dataInicial);   
    $ano    =   $arrayData[2]-1900;
    $mes    =   $arrayData[1];
    $dia    =   $arrayData[0];
    if(!empty($dia))
        $dataI  =   $ano.$mes.$dia;
    else
        $dataI  =   "";
    
    //Data Final
    $dataFinal    =   $_POST['dataF'];
    $arrayData      = explode("/", $dataFinal);   
    $ano    =   $arrayData[2]-1900;
    $mes    =   $arrayData[1];
    $dia    =   $arrayData[0];
    
    if(!empty($dia))
        $dataF  =   $ano.$mes.$dia;
    else
        $dataF  =   "";
    
    $tipo   =   $_POST['tipo'];
    
    $cpf    =   $_POST['CPF'];
    if (!empty($cpf))
    {
        $cpf    = str_replace(".", "", $cpf);
        $cpf    = str_replace("-", "", $cpf);
    }
    else 
        $cpf = "";

        
    $Dados  =   $objORA->retornaDados($loja, $dataI,$dataF, $tipo, $cpf);    
    
    while ($valores = oci_fetch_assoc($Dados))
    {
        $tabela =   "tmp_conferencia_ge";
        
        $campos =   array (
                            "tmp_codigo"    =>  $valores['CERTIFICADO']
                           ,"tmp_loja"      =>  $valores['LOJA']           
                           ,"tmp_data"      =>  $valores['DATA']           
                           ,"tmp_cupom"     =>  $valores['CUPOM']           
                           ,"tmp_cpf"       =>  $valores['CPF']           
                           ,"tmp_cliente"   =>  $valores['CLIENTE']           
                           ,"tmp_valor"     =>  $valores['VALOR']           
                           ,"tmp_status"    =>  $valores['STATUS']           
                           ,"tmp_nome"      =>  $valores['NOME']           
                           ,"tmp_tipo"      =>  $valores['OPER_VEND']           
                          );        
        
        //Inseri na tabela tmp
        $obj->inserir($tabela, $campos);   
                
    } 
    
    //Carrega dados da tabela tmp
    $dadosTmp   =   $obj->retornaDadosTmp($loja, $dataInicial,$dataFinal, $tipo, $cpf, $conferido);

    //Limpa tabela TMP     
    $delim = " 1=1";
    $obj->excluir($tabela, $delim);    
       
}

?>

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="#"                     class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-filter"  ></span>Filtros </a></li>
    </ul>
</div>

<!-- Divs com filtros oculta -->

<div class="conteudo_16 div-filtro">
    <form action="" method="post" class="div-filtro-visivel">
        
        <div class="grid_4">       
            <label class="label">Loja</label>

                <?php if($perfilUsuario[0]==47){?>
                <select name="loja">
                    <option value="">Todas</option>
                    <?php foreach($comboLoja as $campos => $valores){?>
                        <option value="<?php echo $valores['LojaCodigo']?>" <?php echo $valores['LojaCodigo']==$loja?"selected":"";?>><?php echo $obj->preencheZero("E", 3, $valores['LojaCodigo'])."-".$valores['LojaNome'];?></option>
                    <?php }?>
                </select>                    
                <?php }else if($perfilUsuario[0]==48){?>
                <select name="loja" disabled>
                    <?php foreach($comboLoja as $campos => $valores){?>
                        <option value="<?php echo $valores['LojaCodigo']?>" <?php echo $valores['LojaCodigo']==$lojaUsuario?"selected":""?>><?php echo $valores['LojaCodigo']==$lojaUsuario?$obj->preencheZero("E", 3, $valores['LojaCodigo'])."-".$valores['LojaNome']:" 999 - erro";?></option>
                    <?php }?>
                </select>                                    
                <?php }?>

        </div>
            
        <div class="grid_2">       
            <label class="label">Status</label>
            <select name="tipo">
                <option value="">Selecione...</option>
                <option value="ATIVO" <?php echo $tipo=="ATIVO"?"selected":"";?>>ATIVO</option>
                <option value="CANCELADO" <?php echo $tipo=="CANCELADO"?"selected":"";?>>CANCELADO</option>
            </select>
        </div>

        <div class="grid_2">       
            <label class="label">CPF Cliente</label>
            <input type="text" name="CPF"  class="cpf" value="<?php echo $filtro; ?>" />
        </div>

        <div class="grid_2">       
            <label class="label">Data Inicial</label>
            <input type="text" name="dataI" class="data" value="<?php echo $dataInicial;?>" />
        </div>

        <div class="grid_2">       
            <label class="label">Data Final</label>
            <input type="text" name="dataF" class="data" value="<?php echo $dataFinal;?>" />
        </div>                       

        <div class="grid_2">       
            <label class="label">Conferido</label>
            <select name="conferido">
                <option value=""  selected>Selecione... </option>
                <option value="1" <?php echo $conferido=="1"?"selected":"";?>>Sim           </option>
                <option value="0" <?php echo $conferido=="0"?"selected":"";?>>Não           </option>
            </select>
        </div>                       

        
        <div class="grid_2">

            <input type="submit" class="botao-padrao" value="Filtrar">

        </div>          
        
    </form>              
    
    <div class="clear10"></div>
  
</div>
<div class="conteudo_16">
  
    <table class="tablesorter tDados">
        <thead>
            <th>Loja            </th>
            <th>Data            </th>
            <th>Cupom           </th>
            <th>Nº Certificado  </th>
            <th>Nome            </th>
            <th>Tipo            </th>
            <th>CPF Cliente     </th>
            <th style="width:120px;">Nome Cliente    </th>
            <th>Valor           </th>
            <th style="width:auto;">Status          </th>
            
            <?php 
            if(    ($user=='fbezerra') 
                || ($user=='psantos') 
                || ($user=='kscarpan') 
                || ($user=='cmiranda')
                || ($user=='bgondim')
                || ($user=='mmateus')
                || ($user=='ralfieri')
                || ($user=='adsantos')
               ){                            
            ?>
            <th></th>
            <?php }?>
        </thead>
        <tbody>
            <?php
            foreach($dadosTmp as $campos => $valores)
            {   
            ?>
            <tr class="dados">
                <td                       ><?php echo $valores['LOJA'];?>                         </td>
                <td                       ><?php echo $obj->formataDataView($valores['DATA']);?>  </td>
                <td                       ><?php echo strtoupper($valores['CUPOM']);?>            </td>
                <td class="vlrCertificado"><?php echo $valores['CERTIFICADO'];?>                  </td>
                <td                       ><?php echo $valores['NOME'];?>                         </td>
                <td                       ><?php echo $valores['TIPO'];?>                         </td>
                <td                       ><?php echo $valores['CPF'];?>                          </td>
                <td                       ><?php echo $valores['CLIENTE'];?>                      </td>
                <td                       ><?php echo money_format('%.2n',$valores['VALOR']);?>   </td>
                <td                       ><?php echo $valores['STATUS'];?>                       </td>
                <?php if(      ($user=='fbezerra') 
                            || ($user=='psantos') 
                            || ($user=='kscarpan') 
                            || ($user=='bgondim')
                            || ($user=='cmiranda')
                            || ($user=='mmateus')
                            || ($user=='ralfieri')
                            || ($user=='adsantos')
                        ){ 
                ?>            
                <td                                             ><input type="checkbox" class="chkItem" <?php echo $valores['CONFERIDO']==1?"checked":"";?>/></td>
            </tr>
            <?php }?>
        </tbody>  
        <?php $totalValor    +=   1;}?>
        <tfoot style="border: 1px solid green;">
            <tr>
                <td colspan="11" align="right" style=" padding: 5px;">Total Registro(s): <?php echo $totalValor;?></td>
            </tr>        
        </tfoot>           
    </table>
        
</div>