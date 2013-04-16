<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 31/01/2012 por Rodrigo Alfieri
 * Descrição: 
 * Entradas:   
 * Origens:   
           
**************************************************************************
*/

//Instancia Classe

$obj            =   new models_T0026();

$statusDespesa      =   $_REQUEST['statusDespesa'];

//Função para filtro
function FiltroQuery()
{
            
    $obj                =   new models_T0026()                                          ;
    $FiltroNumero       =   $_REQUEST['FiltroNumero']                                      ;        
    $FiltroData         =   $_REQUEST['FiltroData']                                        ;   //tratar a data
    $FiltroElaborador   =   $obj->formataLoginAutoComplete($_REQUEST['FiltroElaborador'])  ;
    $FiltroValor        =   $_REQUEST['FiltroValor']                                       ;
    
    //Formata Data
    if(!empty($FiltroData))
        $FiltroData         =   $obj->formataData($FiltroData);
    
    //Inicializa FiltroQuery
    $FiltroQuery    =   "";
    
    if(!empty($FiltroNumero))
        $FiltroQuery    .=   " AND T16.T016_codigo           =   $FiltroNumero"         ;
    if(!empty($FiltroData))
        $FiltroQuery    .=   " AND T16.T016_dt_elaboracao    =   '$FiltroData'"         ;
    if(!empty($FiltroElaborador))
        $FiltroQuery    .=   " AND T16.T004_login            =   '$FiltroElaborador'"   ;
    if((!empty($FiltroValor)) && ($FiltroValor   >   0))
        $FiltroQuery    .=   " AND T16.T016_vl_total_geral   =   $FiltroValor"          ;
    
    return $FiltroQuery;
}

//Filtro Quantidade de Resgistros em Tela
$FiltroRegistros        =   $_REQUEST['FiltroRegistros']       ;
$filtroReg              =   $_REQUEST['FiltroRegistros']       ; //seleção do combo de Filtro de Registros (propriedade: selected)
if (!empty($FiltroRegistros))
    $FiltroRegistros    =   " LIMIT $FiltroRegistros" ;

$user           =   $_SESSION['user'];

//Status da Despesa
switch ($statusDespesa) {
    case 1:
        $itensFiltrados =   $obj->retornaDespesasPendentesAprovacao($user,FiltroQuery(),$FiltroRegistros);
        break;
    case 2:
        $itensFiltrados =   $obj->retornaDespesasDigitadas($user,FiltroQuery(),$FiltroRegistros);
        break;
    case 3:
        $itensFiltrados =   $obj->retornaDespesasAnteriores($user,FiltroQuery(),$FiltroRegistros);
        break;
    case 4:
        $itensFiltrados =   $obj->retornaDespesasPosteriores($user,FiltroQuery(),$FiltroRegistros);
        break;
    case 5:
        $itensFiltrados =   $obj->retornaDespesasFinalizadas($user,FiltroQuery(),$FiltroRegistros);
        break;
    case 6:
        $itensFiltrados =   $obj->retornaDespesasCanceladas($user,FiltroQuery(),$FiltroRegistros);
        break;
}
?>
<!-- Caixa Dialogo Excluir -->
<div id='dialog-confirm' title='Mensagem!' style='display:none'>
    <p><span class='ui-icon ui-icon-alert' style='float:left; margin:0 7px 20px 0;'></span>Tem certeza que deseja excluir este item?</p>
</div>
<!-- Caixa Dialogo Aprovar -->
<div id="dialog-aprovar" title="Mensagem!" style="display:none">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja aprovar essa(s) Despesa(s)?</p>
</div>
<!-- Caixa Dialogo Cancelar -->
<div id="dialog-cancelar" title="Mensagem!" style="display:none">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja cancelar essa Despesa?</p>
</div>
<!-- Caixa de Upload-->
<div id="dialog-upload" title="Upload" style="display:none">
	<p    class="validateTips">Selecione um tipo e um arquivo para carregar no sistema!</p>
        <span class="form-input">
	<form action="?router=T0026/js.upload" method="post" id="form-upload"  enctype="multipart/form-data">
            <fieldset>
                    <label class="label">Escolha o Arquivo*</label>                
                    <input type="file"      name="despesaArquivo"               id="arquivo"            />
            </fieldset>
	</form>
        </span>
</div>
<!-- FIM Caixa de Upload-->

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="?router=T0026/novo"    class="             botao-padrao"><span class="ui-icon ui-icon-plus"    ></span>Novo    </a></li>
        <li><a href="#"                     class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-filter"  ></span>Filtros </a></li>
    </ul>
</div>

<!-- Divs com filtros oculta -->
<div class="conteudo_16  div-filtro">
    
    <form action="?router=T0026/home/" method="get" class="div-filtro-visivel">
        <input type="hidden" name="router" value="T0026/home" />

        <div class="grid_5">
            <label class="label">Status</label>
            <select name="statusDespesa" id="statusDespesa">
                <option value="0" <?php echo $statusDespesa==0?"selected":""?>>Selecione...                    </option>
                <option value="1" <?php echo $statusDespesa==1?"selected":""?>>Aguardando Minha Aprovação      </option>
                <option value="2" <?php echo $statusDespesa==2?"selected":""?>>Minhas Digitadas (não aprovadas)</option>
                <option value="3" <?php echo $statusDespesa==3?"selected":""?>>Anteriores a Mim                </option>
                <option value="4" <?php echo $statusDespesa==4?"selected":""?>>Posteriores a Mim               </option>
                <option value="5" <?php echo $statusDespesa==5?"selected":""?>>Finalizadas                     </option>
                <option value="6" <?php echo $statusDespesa==6?"selected":""?>>Canceladas                      </option>
            </select>
        </div>
        
        <div class="grid_2">
            <label class="label">Nº Despesa</label>
            <input type="text" name="FiltroNumero" size="10"                value="<?php echo $_REQUEST['FiltroNumero'];?>"/>               
        </div>
        
        <div class="grid_2">
            <label class="label">Data Elaboração</label>
            <input type="text" name="FiltroData" class="data"               value="<?php echo $_REQUEST['FiltroData'];?>"/>               
        </div>
        
        <div class="grid_3">
            <label class="label">Elaborador</label>
            <input type="text" name="FiltroElaborador" class="buscaUsuario" value="<?php echo $_REQUEST['FiltroElaborador'];?>"/>             
        </div>
        
        <div class="grid_2">
            <label class="label">Valor</label>
            <input type="text" name="FiltroValor" class="valor"             value="<?php echo $_REQUEST['FiltroValor'];?>"/>              
        </div>
        
        <div class="grid_2">
        <label class="label">Qtde Registros</label>
            <select name="FiltroRegistros">
                <option value="50"  <?php echo $filtroReg==50 ?"selected":""?>>50     </option>
                <option value="100" <?php echo $filtroReg==100?"selected":""?>>100    </option>
                <option value=""    <?php echo $filtroReg=="" ?"selected":""?>>Todos  </option>
            </select>            
        </div>

        <div class="grid_1">
            <input type="submit" class="botao-padrao" value="Filtrar">
        </div>
        
        <div class="clear5"></div>
                
    </form>
    
</div>

<div class="conteudo_16">

    <div class="grid_3">
        <input type="button" class="botao-padrao aprovarSelecionados" value="Aprovar Selecionados" <?php echo $statusDespesa!=1?"disabled":""?>>
    </div>    
    
    <div class="clear10"></div>
    
    <table class="tablesorter tDados">
        <thead>
            <tr>
                <!--<th><input type="checkbox" value="1" class="chkSelecionaTodos" <?php echo $statusDespesa!=1?"disabled":""?>/></th>-->
                <th>Despesa Nº</th>
                <th>Elaborado Por</th>
                <th>Data</th>
                <th>Última Etapa</th>
                <th>Valor</th>
                <!--<th>Arquivos</th>-->
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php   foreach($itensFiltrados as $campos=>$valores){?>            
            <tr>
                <td class="codigoDespesa"   style="display:none;"><?php echo $valores['DespesaCodigo'];?></td>
                <td class="codigoEtapa"     style="display:none;"><?php echo $valores['CodigoEtapa'];?></td>
                <td><?php echo $valores['DespesaCodigo']; ?></td>
                <td><?php echo $valores['Login']; ?></td>
                <td><?php echo $valores['DespesaData']; ?></td>
                <td><?php $UltimaEtapa  =   $obj->retornaUltimaAprovacao($valores['DespesaCodigo']);                    
                    foreach($UltimaEtapa    as  $camposEtp =>  $valoresEtp){
                    $Etapa = $obj->preencheZero("E", 3, $valoresEtp['GrupoCodigo']) . "-" . $valoresEtp['GrupoNome'] .' ('. $valoresEtp['Login'] .')'. "</BR></BR>" . $valoresEtp['DtAprovacao']."</BR>". $valoresEtp['TimeAprovacao'];                            
                    ?>
                    <p  class="texto-alinhado-justificado" 
                        onmouseover ="show_tooltip_alert('','<?php echo $obj->tabelaToolTipFluxoWorkFlow($valores['DespesaCodigo'], 16);?>');tooltip.pnotify_display();" 
                        onmousemove ="tooltip.css({'top': event.clientY+12, 'left': event.clientX+12});"
                        onmouseout  ="tooltip.pnotify_remove();"><?php echo $Etapa; ?></p>
                    <?php }?>
                </td>
                <td><?php echo $obj->formataMoeda($valores['DespesaValor'])?></td>
<!--                <td>                        <?php $ArquivosDespesa  =   $obj->retornaArquivos($valores['DespesaCodigo']);?>
                        <?php foreach($ArquivosDespesa  as  $cpsArquivo =>  $vlsArquivo){
                                $Categoria      =   $vlsArquivo['CategoriaCodigo']                          ;
                                $ArquivoCodigo  =   $vlsArquivo['ArquivoCodigo']                            ;
                                $Extensao       =   $vlsArquivo['ExtensaoNome']                             ;
                                $LinkArquivo    =   $obj->linkArquivo($Categoria, $ArquivoCodigo, $Extensao);
                            
                            
                            ?>
                        <a target="_blank" href="<?php echo $LinkArquivo?>"><?php echo $vlsArquivo['ArquivoNome'];?></a>  <?php if ($statusDespesa==1){?>|  <a href="javascript:excluir('T0026','T0026/home&cod=<?php echo $valores['DespesaCodigo'];?>&path=<?php echo $obj->preencheZero("E", 4, $Categoria)."/".$obj->preencheZero("E", 4, $ArquivoCodigo).".".$Extensao;?>','T016_T055','T055_codigo','<?php echo $vlsArquivo['ArquivoCodigo']?>')">Excluir</a><?php }?>
                        <?php }?>
                </td>-->
                <td style="display:none;"><?php echo $valores['DespesaCodigo'];?>;EtapaCodigo:<?php echo $valores['CodigoEtapa'];?></td>
                <td>                                    
                    <ul class="lista-de-acoes">                                        
                        <li><a href="?router=T0026/detalhes&despesaCodigo=<?php echo $valores['DespesaCodigo']?>" title="Detalhes"><span class='ui-icon ui-icon-search'></span></a></li>
                        <!--<li><a href="javascript:upload(<?php echo $valores['DespesaCodigo'];?>)" title="Anexar"  >  <span class='ui-icon ui-icon-pin-s'></span></a></li>-->
                        <li><a target="_blank" href="?router=T0026/js.pdf&DespesaCodigo=<?php echo $valores['DespesaCodigo'];?>" title="Imprimir"><span class='ui-icon ui-icon-print'></span></a></li>
                        <li><a href="#" title="Aprovar"     class="aprovarDespesa"  ><span class='ui-icon ui-icon-check'>   </span></a></li>                                    
                        <li><a href="#" title="Cancelar"    class="cancelarDespesa" ><span class='ui-icon ui-icon-cancel'>  </span></a></li>                                    
                        <li><a href="#" title="Upload"      class="uploadArquivo"   ><span class='ui-icon ui-icon-pin-s'>  </span></a></li>                                    
                    </ul>
                </td>
            </tr>
        <?php }?>
        </tbody>
        
    </table>
    
</div>




