<?php
//Instancia Classe
$obj    =   new models_T0095();

$user = $_SESSION['user'];
$perfil = $obj->retornaPerfil($user);

foreach ($perfil as $key => $value) {
    
    $perfilUser =   $value["PERFIL"];
    
}

$retornaConfirmados =   $obj->retornaStatusItens($auditoria);

// Loja do usuário
$retornaLojaUsu     =   $obj->retornaLojas($_SESSION['user']);

foreach($retornaLojaUsu as $campos=>$valores)
{
    $codigoLoja     =   $valores['Codigo'];
} 

$SelectBoxLoja  =   $obj->retornaLojasSelectBox();

if (!empty($_POST))
{
    $loja       =   $_POST['loja'];
    $arquivo    =   $_POST['arquivo'];
    $dt_inicio  =   $_POST['dt_inicio'];
    $dt_fim     =   $_POST['dt_fim'];
    
        
    $retornaItens   =   $obj->retornaAuditoria($loja, $arquivo, $dt_inicio, $dt_fim);
}  
?>

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="#"                     class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-filter"  ></span>Filtros </a></li>
        <li><a href="<?php echo ROUTER."grafico";?>"                     class="botao-padrao"><span class="ui-icon ui-icon-image"  ></span>Gráfico</a></li>
    </ul>
</div>

<!-- Divs com filtros oculta -->
<form action="" method="post" class="div-filtro-visivel formCad formulario">
    <div class="conteudo_16">
        
        <div class="grid_4">       
            <label class="label">Loja</label>
            <select name="loja">
                <option value="">Todas</option>
                <?php foreach($SelectBoxLoja as $campos=>$valores){?>
                <option value="<?php echo $valores['LojaCodigo']?>" <?php echo $valores['LojaCodigo']==$loja?"selected":"";?>><?php echo $obj->preencheZero("E",3,$valores['LojaCodigo'])."-".$valores['LojaNome'];?></option>
                <?php }?>
            </select>                                       
        </div>

        <div class="grid_2">       
            <label class="label">Nº Auditoria</label>
            <input type="text" name="arquivo" value="<?php echo $arquivo;?>"/>
        </div>
        
        <div class="grid_2">       
            <label class="label">Data Início</label>
            <input type="text" name="dt_inicio" value=""  class="validate[required,custom[date]] form-input-text-table data"/>
        </div>
        
        <div class="grid_2">       
            <label class="label">Data Fim</label>
            <input type="text" name="dt_fim" value="<?php echo date("d/m/Y");?>" class="data"/>
        </div>

        <div class="grid_2">
            <input type="submit" class="botao-padrao" value="Filtrar">
        </div>          

    </div>
</form>  
<div id="conteudo">
    <span class="lista_itens">
	<table class="tablesorter tDados">
            <thead>
                <tr class="ui-widget-header ">
                    <th>Data                       </th>
                    <th>Auditoria                  </th>
                    <th>Classificação Mercadológica</th>
                    <th>Apuração                   </th>
                    <th>Relatórios                 </th>
                </tr>
            </thead>
            <tbody class="campos">
                <?php foreach($retornaItens as $campos => $valores){ ?>
                <tr class="linha">
                    <td align="center"><?php echo $valores['Data'];?></td>
                    <td align="center" class="codigoAuditoria"><?php echo $valores['CodigoAuditoria'];?></td>
                    <td>                        
                        <table>
                            <?php   
                                   $a   =   0;
                                   $retornaConfirmados =   $obj->retornaStatusItens($valores['CodigoAuditoria']); 
                                   foreach ($retornaConfirmados as $cps => $valoresStatus) {
                                       $a++;
                                       
                                   }
                            
                                   $Depto       =   $valores['Departamento']    ;
                                   $Secao       =   $valores['Secao']           ;
                                   $Grupo       =   $valores['Grupo']           ;
                                   $Subgrupo    =   $valores['Subgrupo']        ;
                                   $ruptura     =   $valores['Ruptura']         ;
                                   $RupLoja     =   $valores['RupturaLoja']     ;
                                   $RupCom      =   $valores['RupturaCom']      ;
                                   $erros       =   $valores['Erro']            ;
                                   $erroPrc     =   $valores['ErroPrc']         ;
                                   $erroEtq     =   $valores['ErroEtq']         ;
                                   $foraLinha   =   $valores['ForaLinha']       ;
                                   $cadastro    =   $valores['SemCadastro']     ;

                                   if (empty($ruptura))
                                       $ruptura     =   0;
                                   if (empty($erros))
                                       $erros       =   0;
                                   if (empty($cadastro))
                                       $cadastro    =   0;

                            ?>
                            <tr>
                                <th align="left" width="2%">Departamento:</th>
                                <th align="left" width="20%"><?php echo $Depto."-".$obj->retornaDescricaoClassificacao($Depto,0,0,0)?></th>
                            </tr>
                            <?php if (!empty($Secao)){?>
                            <tr>
                                <th align="left">Seção:</th>
                                <th align="left"><?php echo $Secao."-".$obj->retornaDescricaoClassificacao($Depto,$Secao,0,0)?></th>
                            </tr>
                            <?php } if (!empty($Grupo)){?>
                            <tr>
                                <th align="left">Grupo:</th>
                                <th align="left"><?php echo $Grupo."-".$obj->retornaDescricaoClassificacao($Depto,$Secao,$Grupo,0)?></th>
                            </tr>                            
                            <?php } if (!empty($Subgrupo)){?>
                            <tr>                                    
                                <th align="left">SubGrupo:</th>
                                <th align="left"><?php echo $Subgrupo."-".$obj->retornaDescricaoClassificacao($Depto,$Secao,$Grupo,$Subgrupo)?></th>
                            </tr>                            
                            <?php }?>
                        </table>
                    </td>
                    <td><table>
                            <tr>
                                <th align="left">Itens:</th>
                                <th align="left"><?php echo $valores['QtdeItens'];?></th>
                            </tr>
                            <tr>
                                <th align="left">Em Linha:</th>
                                <th align="left"><?php echo $valores['EmLinha'];?></th>
                            </tr>
                            <tr>
                                <th align="left">Auditados:</th>
                                <th align="left"><?php echo $valores['Auditados'];?></th>
                            </tr>
                            <tr>                                    
                                <th align="left">Divergentes:</th>
                                <th align="left"><?php echo $valores['Divergente'];?></th>
                            </tr>
                            <tr>                                    
                                <th align="left">Fora Linha Em Loja:</th>
                                <th align="left"><?php echo $valores['ForaLinha'];?></th>
                            </tr>
                            <tr>                                    
                                <th align="left">Fora Seleção:</th>
                                <th align="left"><?php echo $cadastro;?></th>
                            </tr>
                            <tr>                                    
                                <th align="left" style="background-color: #4876FF;">% Ruptura(s)</th>
                                <th align="left" style="background-color: #4876FF;"><?php echo number_format($ruptura, 2, ',', '.');?></th>
                            </tr>
                            <tr>                                    
                                <th align="left" style="background-color: #C1CDCD;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Comercial</th>
                                <th align="left" style="background-color: #C1CDCD;"><?php echo number_format($RupCom, 2, ',', '.');?></th>
                            </tr>
                            <tr>                                    
                                <th align="left" style="background-color: #C1CDCD;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Loja</th>
                                <th align="left" style="background-color: #C1CDCD;"><?php echo number_format($RupLoja, 2, ',', '.');?></th>
                            </tr>
                            <tr>                                    
                                <th align="left" style="background-color: #CD5555;">% Erro(s)</th>                                
                                <th align="left" style="background-color: #CD5555;"><?php echo number_format($erros, 2, ',', '.');?></th>                                
                            </tr>
                            <tr>
                                <th align="left" style="background-color: #FFC1C1;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Preço Divergente</th>                              
                                <th align="left" style="background-color: #FFC1C1;"><?php echo number_format($erroPrc, 2, ',', '.');?></th>
                            </tr>
                            <tr>
                                <th align="left" style="background-color: #FFC1C1;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sem Etiqueta</th>                              
                                <th align="left" style="background-color: #FFC1C1;"><?php echo number_format($erroEtq, 2, ',', '.');?></th>
                            </tr>
                            <?php if($obj->verificaPerfilUsuario($user, '55, 56' ) == 1){?>
                            <tr>
                                <th align="center" colspan="2">
                                    <div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
                                        <ul class="lista-horizontal">
                                            <?php 
                                                if((($perfilUser ==  56) &&($valores["Gerente"] == 1) && ($a == 0)) || (($perfilUser ==  55) &&($valores["CoordInventario"] == 1) && ($a == 0) )){   ?>
                                            <li><a href="#"                     class="botao-padrao-verde rupturaItens"><span class="ui-icon ui-icon-newwin"  ></span>Ruptura</a></li>
                                            <?php } elseif ((($perfilUser ==  56) &&($valores["Gerente"] == 1) && ($a > 0)) || (($perfilUser ==  55) &&($valores["CoordInventario"] == 1) && ($a > 0))) {  ?>
                                            <li><a href="#"                     class="botao-padrao-vermelho rupturaItens"><span class="ui-icon ui-icon-newwin"  ></span>Ruptura</a></li>
                                            <?php } elseif (($valores["Data"] <> date("d/m/Y")) && ($a>0)) {  ?>
                                            <li><p style="background-color:  #CD5555;  padding-top: 15px; height: 15px;">Ruptura Não Confirmada</p></li>
                                            <?php } elseif ($RupLoja <= 0 ) {  ?>
                                            <li><p style=" padding-top: 15px; height: 15px;">Não Há Rupturas Loja.</p></li>
                                            <?php } else { ?>
                                            <li><a href="#"                     class="botao-padrao rupturaItens"><span class="ui-icon ui-icon-newwin"  ></span>Ruptura</a></li>
                                            <?php }?>
                                        </ul>  
                                    </div>
                                </th>
                            </tr><?php }  ?>
                        </table></td>
                    <td><table>
                            <?php   if ($foraLinha!=0){?>
                            <tr>
                                <th align="center"><a href="?router=T0095/js.pdfForaLinha&codigoAuditoria=<?php echo $valores['CodigoAuditoria']?>" target="_blank">Fora Linha Em Loja</a></th>
                            </tr>
                            <?php } if ($erroPrc!=0){?>
                            <tr>
                                <th align="center"><a href="?router=T0095/js.pdfErroPreco&codigoAuditoria=<?php echo $valores['CodigoAuditoria']?>" target="_blank">Erro(s) de Preço(s)</a></th>
                            </tr>
                            <?php } if ($erroEtq!=0){?>
                            <tr>
                                <th align="center"><a href="?router=T0095/js.pdfErroEtiqueta&codigoAuditoria=<?php echo $valores['CodigoAuditoria']?>" target="_blank">Erro(s) de Etiqueta(s)</a></th>
                            </tr>
                            <?php } if ($ruptura!=0){?>
                            <tr>
                                <th align="center"><a href="?router=T0095/js.pdfRupturaComercial&codigoAuditoria=<?php echo $valores['CodigoAuditoria']?>" target="_blank">Ruptura Comercial</a></th>
                            </tr>
                            <tr>
                                <th align="center"><a href="?router=T0095/js.pdfRupturaLoja&codigoAuditoria=<?php echo $valores['CodigoAuditoria']?>" target="_blank">Ruptura Loja</a></th>
                            </tr>
                            <?php } if ($cadastro!=0){?>
                            <tr>
                                <th align="center"><a href="?router=T0095/js.pdfSemCadastro&codigoAuditoria=<?php echo $valores['CodigoAuditoria']?>" target="_blank">Fora Seleção</a></th>
                            </tr>
                            <?php }?>
                        </table></td>
                </tr>
                <?php }?>
            </tbody>
	</table>
    </span>
        <span class="form-input">
            <div class="form-inpu-botoes">
            </div>   
        </span>    

</div>
