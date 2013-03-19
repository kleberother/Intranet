<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 19/09/2011 por Rodrigo Alfieri
 * Descrição: Programa para associar produtos aos painéis
 * Entradas:  PainelCodigo, PainelNome, PainelDepto, PainelSecao, PainelGrupo e PainelSubGrupo
 * Origens:   Home
           
***************************************************************************/
//Classe para ***
//Cria objeto para encontrar as models do programa 29
$obj                    = new models_T0034();
//Pega parametros
$PainelCodigo           =   $_REQUEST['Painel']         ;           //codigo do painel
$TemplateCodigoArea     =   $_REQUEST['T080_codigo']    ;           //código area template
// Retorna os detalhes do painel para utilizar no resto do programa
$Painel     = $obj->retornaDetalhesPainel($PainelCodigo) ;

foreach ($Painel as $campos=>$valores)
{
    $PainelDescricao    =   $valores['PainelDescricao'] ; //descricao do painel
    $PainelDepto        =   $valores['Departamento']    ;           //depto do painel   
    $PainelSecao        =   $valores['Secao']           ;           //secao do painel   
    $PainelGrupo        =   $valores['Grupo']           ;           //grupo do painel
    $PainelSubGrupo     =   $valores['SubGrupo']        ;           //subgrupo do painel
    $TemplateCodigo     =   $valores['TemplateCodigo']  ;           //código template   
    $SecaoPropria       =   $valores['SecaoPropria']    ;
    $LojaCodigo         =   $valores['LojaCod']         ; 
}

$FiltroDepto    = $PainelDepto     ;
$FiltroSecao    = $PainelSecao     ; 
$FiltroGrupo    = $PainelGrupo     ;
$FiltroSubGrupo = $PainelSubGrupo  ;


// Monta o select box de filtros de departamento
$Deptos     =   $obj->retornaDeptos() ;
$Secoes     =   $obj->retornaSecoes($FiltroDepto);
$Grupos     =   $obj->retornaGrupos($FiltroDepto, $FiltroSecao);
$SubGrupos  =   $obj->retornaSubGrupos($FiltroDepto, $FiltroSecao, $FiltroGrupo);
 
$Associados             =   $obj->retornaProdutosAssociados($PainelCodigo);

// RETORNA DADOS PARA PREENCHER SELECT BOX DE TEMPLATES
$AreasTemplateFiltro    =   $obj->retornaAreasTemplate($TemplateCodigo);
$AreasTemplate          =   $obj->retornaAreasTemplate($TemplateCodigo);

$RotaPagina             = "T0034/associar&Painel=".$PainelCodigo."&T080_codigo=".$TemplateCodigoArea."&T020_departamento=".$FiltroDepto."&T020_secao=".$FiltroSecao."&T020_grupo=".$FiltroGrupo."&T020_subgrupo=".$FiltroSubGrupo;

if(!empty($_POST))
{  
    $tabela = "T075_T078_T080";
   //Retira último elemento Array (campo Associar)
    foreach($_POST['Produtos'] as $campos => $valores)
   {    
        $TemplateArea   =   $_POST['T080_codigo'];
        //Monta array para codigo e digito
        $CodigoComDigito   = split("-",$valores);
        //separa array de codigo e digito
        $Codigo = $CodigoComDigito[0];
        $Digito = $CodigoComDigito[1];
        //monta array para insert
        $array  = array("T075_codigo"               => $Codigo
                       ,"T075_digito"               => $Digito
                       ,"T078_codigo"               => $PainelCodigo
                       ,"T080_codigo"               => $TemplateCodigoArea
                       ,"T076_codigo"               => $TemplateCodigo
                       ,"T075_T078_T080_visivel"    => 1);        
        //insere
        $insere = $obj->inserirProduto($tabela, $array);
        header("location:?router=".$RotaPagina);
    }
}
?>
<script src='template/js/interno/T0034/produtos.js'></script>
<script src='template/js/interno/T0034/checkbox.js'></script>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0034/home">Listar</a></li>
                <li><a href="?router=T0034/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="conteudo">
    <span class="form-titulo">
        <p>Painel: <?php echo $PainelCodigo." - ".$PainelDescricao;?></p>
    </span>
</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Associar Itens ao Painel</a></li>
    </ul>
    <!-- DIV ABAIXO, MOSTRA O FORMULÁRIO DE PERMISSÃO PARA DEPARTAMENTO - INICIO --------------------------------------------------------------------------------------------------- -->
    <div id="tabs-1">
        <div id="formulario">
            <span class="form-input">
            <form action="" method="post" id="formCad">
                <table>
                    <tr>
                        <td colspan="2"><label class="label">Área do Template*</label></td>
                        <td><label class="label" style="display:none;" id="labelProdutos">Produtos *</label></td>
                    </tr>   
                    <tr>
                        <td colspan="2"  valign="top" style="vertical-align: top;">
                            <select  name="T080_codigo" class="validate[required]" id="TemplateArea">
                                <option value="">Selecione...</option>
                                <?php
                                foreach($AreasTemplateFiltro as $campos=>$valores){?> 
                                    <option value="<?php echo $valores['AreaCod']; ?>"<?php echo($valores['AreaCod']==$FiltroArea)?" selected":($_POST['Area']==$valores['AreaCod'])?"selected":"";?>><?php echo $obj->preencheZero("E", 3, $valores['AreaCod'])." - ".$valores['AreaNome']; ?></option>
                                <?php }?>
                            </select>                        
                        </td>
                        <td rowspan="6">                        
                            <select name="Produtos[]" id="Produtos" class="validate[required]" style="width: 300px; height: 150px; display:none;" multiple>
                                <?php
                                foreach($Produtos as $campos=>$valores){
                                ?>
                                    <option value="<?php echo $valores['Codigo']."-".$valores['Digito']; ?>"><?php echo $obj->preencheZero("E", 5, $valores['Codigo'])."-".$valores['Digito']." ".$valores['Descricao']; echo (!empty($valores['Arquivo']))?"<b>  (Com Foto)</b>":"" ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>   
                    <tr>
                        <td><label class="label" style="display:none;" id="labelCodigo"     >Código     </label></td>
                        <td><label class="label" style="display:none;" id="labelDescricao"  >Descrição  </label></td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="T075_codigo"  id="ProdutoCodigo" style="display:none;"/>
                        </td>
                        <td>
                            <input type="text" name="T075_descricao" id="ProdutoDescricao" style="display:none;"/>
                        </td>                        
                    </tr>                  
                    <tr>
                        <td><label class="label" style="display:none;" id="labelDepartamento"   >Departamento   </label></td>
                        <td><label class="label" style="display:none;" id="labelSecao"          >Seção          </label></td>
                    </tr>
                    <tr>                        
                        <td>
                            <select name="T020_departamento" id="ProdutoDepartamento" <?php if ($SecaoPropria == 1) echo "disabled" ?> style="display:none;"    >
                                <option value="null">Selecione...</option>
                                <?php foreach($Deptos as $campos=>$valores){?>
                                    <option value="<?php echo $valores['Depto'];?>" <?php if($valores['Depto'] == $FiltroDepto) echo "selected"?>><?php echo $obj->preencheZero("E", 3, $valores['Depto'])." - ".$valores['Descricao'];?></option>
                                <?php }?>
                            </select>                             
                        </td>
                        <td>
                                <select name="T020_secao" id="ProdutoSecao" <?php if ($SecaoPropria == 1) echo "disabled" ?> style="display:none;">                                 
                                <option value="null">Selecione...</option>                             
                                <?php foreach($Secoes as $campos=>$valores){?>
                                    <option value="<?php echo $valores['Codigo'];?>"<?php if($valores['Codigo'] == $FiltroSecao) echo "selected"?>><?php echo $obj->preencheZero("E", 3, $valores['Codigo'])." - ".$valores['Descricao'];?></option>
                                <?php }?>           
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label class="label" style="display:none;" id="labelGrupo"      >Grupo      </label></td>
                        <td><label class="label" style="display:none;" id="labelSubGrupo"   >SubGrupo   </label></td>
                    </tr>                    
                    <tr>    
                        <td>
                            <select name="T020_grupo" id="ProdutoGrupo" <?php if ($SecaoPropria == 1) echo "disabled" ?> style="display:none;"> 
                                <option value="null">Selecione...</option>
                                <?php  foreach($Grupos as $campos=>$valores){?>
                                    <option value="<?php echo $valores['Codigo'];?>"<?php if($valores['Codigo'] == $FiltroGrupo) echo "selected"?>><?php echo $obj->preencheZero("E", 3, $valores['Codigo'])." - ".$valores['Descricao'];?></option>                                 
                                <?php }?>
                            </select>
                        </td>
                        <td>
                            <select name="T020_subgrupo" id="ProdutoSubGrupo" <?php if ($SecaoPropria == 1) echo "disabled" ?> style="display:none;">
                                <option value="null">Selecione...</option>
                                <?php  foreach($SubGrupos as $campos=>$valores){?>
                                    <option value="<?php echo $valores['Codigo'];?>"<?php if($valores['Codigo'] == $FiltroSubGrupo) echo "selected"?>><?php echo $obj->preencheZero("E", 3, $valores['Codigo'])." - ".$valores['Descricao'];?></option>                                 
                                <?php }?>
                            </select>
                        </td>                    
                    </tr>
                    </table>

                <input type="hidden" value="<?php echo $PainelCodigo?>" id="PainelCodigo"/>
                <input type="hidden" value="<?php echo $TemplateCodigo?>" id="TemplateCodigo"/>
                <div class="form-inpu-botoes">
                    <input type="submit" value="Associar" id="Associar"/>
                </div>
                </form>
            </span>
        </div>
        <div id="conteudo2">
            <span class="lista_itens">
                <table class="ui-widget ui-widget-content">
                        <thead>
                                <tr class="ui-widget-header ">
                                        <th width="2%"  >Visível    </th>
                                        <th             >Área       </th>
                                        <th             >Produto    </th>
                                        <th width="7%"  >Ações      </th>
                                </tr>
                        </thead>
                        <tbody class="dados"> <?php $i==0;?>
                                <?php foreach($Associados as $campos=>$valores){ ?>
                                <tr>
                                    <td><input type="checkbox" name="selecionaItem[]" id="selecionaItem" value="<?php echo $PainelCodigo.",".$valores['AreaCodigo'].",".$valores['ItemCodigo'];?>" <?php echo ($valores['Visivel']==1)?"checked":""; ?> ></td>
                                    <td><?php echo $valores['AreaCodigo']."-".$valores['AreaNome'];?></td>
                                    <td><?php echo $valores['ItemCodigo']."-".$valores['ItemDigito']." ".$valores['ItemDescricao']; echo (!empty($valores['Arquivo']))?"<b>  (Com Foto)</b>":""?></td>
                                    <td class="acoes">
                                        <span class="lista_acoes">
                                            <ul>
                                                <li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0034','<?php echo $RotaPagina?>','T075_T078_T080','T075_codigo,T078_codigo,T080_codigo','<?php echo ($valores['ItemCodigo'].','.$PainelCodigo.','.$valores['AreaCodigo']);?>','','',1)" class="ui-icon ui-icon-closethick"></a></li>
                                            </ul>
                                        </span>
                                    </td>
                                </tr>
                                <?php $i++;} if($i==0) { ?>
                                <tr>
                                    <td colspan="5">Não há produtos associados a esse painel!</td>
                                </tr>                                
                               <?php } ?>   
                        <!-- Caixa Dialogo Excluir -->
                        <div id="dialog-confirm" title="Mensagem!" style="display:none">
                            <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja excluir este item?</p>
                        </div>
                        </tbody>
                </table>
            </span>           
        </div>
    </div>
    <!-- DIV ACIMA, MOSTRA O FORMULÁRIO DE PERMISSÃO PARA DEPARTAMENTO - FINAL  --------------------------------------------------------------------------------------------------- -->
    
</div>

<?php
/* -------- Controle de versões - home.php --------------
 * 1.0.0 - 19/09/2011   --> Liberada a versão
 * 1.0.1 - 20/09/2011   --> Inclusão dos Filtros
*/
?>