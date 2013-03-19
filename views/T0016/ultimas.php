<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 13/09/2011 por Alexandre Alves                              
 * Descrição: Programa para apresentar as Ultimas N (parametro) Aps do fornecedor
 * Entrada:   FornCodigo --> Codigo do fornecedor (Intranet)
 * Origens:   home
           
**************************************************************************
*/

$user         = $_SESSION['user'];
$tipo         = $_REQUEST['tipo'];
$FornCodigo   = $_GET['FornCodigo'];
$Loja         = $_GET['Loja'];
//Chama classes
//Classe para APS
$objUltimasAps        =  new models_T0016($conn);

// retorna quantidade maxima do parametro
$UltimasAps = $objUltimasAps->RetornaParametroQtdeMaxAps();
foreach($UltimasAps as $camposQtdeMax=>$valoresQtdeMax)
 {
    $QtdeMax = $valoresQtdeMax['ParametroValor'];
 }
//procura Ultimas APs do Fornecedor
$UltimasAps = $objUltimasAps->retornaUltimasApsFornecedor($FornCodigo,'',$QtdeMax, $Loja);
$Fornecedor = $objUltimasAps->RetornaDetalhesFornecedor($FornCodigo);

?>
<div id="formulario" class="formulario">
    <span class="form-titulo">
        <p>APs apresentadas:  <?php echo $QtdeMax ?> </p>
    </span>

    <span class="form-titulo">
        <p>Dados do Fornecedor:  <?php echo $FornCodigo ?> </p>
    </span>
    <span class="form-input">
        <table>
            <tr>
                <td><label class="label">CNPJ / CPF              </label></td>
                <td><label class="label">Cod RMS               </label></td>
                <td><label class="label">Razão Social          </label></td>
                <td><label class="label">Inscrição Estadual    </label></td>
                <td><label class="label">Inscrição Municipal / RG</label></td>
            </tr>
            <tr>
            <?php
                  foreach($Fornecedor as $camposFornecedor=>$valoresFornecedor)
                  {
                      //Formatando CNPJ;
                      $cgc_cnpj          = $objUltimasAps->FormataCGCxCPF($valoresFornecedor['CNPJ']);
            ?>                
                
                    <td><p><?php echo $cgc_cnpj;?>                                                </p></td>
                    <td><p><?php echo $valoresFornecedor['RMSCodigo']."-".$valoresFornecedor['RMSDigito'];?></p></td>
                    <td><p><?php echo $valoresFornecedor['RazaoSocial'];?></p></td>
                    <td><p><?php echo $valoresFornecedor['IE'];?>                               </p></td>
                    <td><p><?php echo $valoresFornecedor['IM'];?></p></td>
              <?php } ?>  
            </tr>
        </table>
    </span>
</div>

    <div id="tabs-1">
        <div id="conteudo">
            <span class="lista_itens">
                <label><h1><b><?php echo $msgFiltro;?></b></h1></label>
                <table class="ui-widget ui-widget-content">
                        <thead>
			<tr class="ui-widget-header ">
                            <th width="6%">AP N°                    </th>
                            <th width="9%">Nota Fiscal<br/>Série    </th>
                            <th width="8%">Elaborado<br/>por        </th>
                            <th>Loja Faturada                       </th>
                            <th width="8%">Vencimento               </th>
                            <th width="15%">Valor                    </th>
                            <th>Arquivos                            </th>
                            <th width="12%">Tipo Despesa            </th>
                            <th width="12%">Status                   </th>
			</tr>
                        </thead>
                        <tbody>
                                <?php
                                foreach($UltimasAps as $campos=>$valores){
                                //verifica o tipo do filtro para trazer os restulados com a posição correta do array

                                //Formatando Valor Bruto
                                $ValorBruto     = money_format('%n', $valores['ValorBruto']);
                                ?>
                                <tr class="dados">
                                        <td><a href='?router=T0016/detalhe&cod=<?php echo $valores['APCodigo'];?>&orig=ultimas&FornCodigo=<?php echo $FornCodigo ?>' target="_blank"><?php echo $valores['APCodigo'];?></a></td>
                                        <td><?php echo $valores['NFNumero']."<br/>".$valores['NFSerie'];?></td>
                                        <td><?php echo $valores['Login'];?></td>
                                        <td><?php echo $valores['CodigoLoja']." - ".$valores['NomeLoja']; ?></td>
                                        <td><?php echo $valores['DtVencimento'];?></td>

                                        <td><?php echo $ValorBruto;?></td>
                                        <td>
                                            <table class="list-iten-arquivos">
                                            <?php $Arq = $objUltimasAps->selecionaArquivos($valores['APCodigo']); foreach($Arq  as  $campos=>$valores2){
                                                 if( $cont%2 == 0)
                                                        $cor = "line_color";
                                                 else
                                                        $cor = "";
                                                 $cont++;
                                                ?>
                                                <tr class="<?php echo $cor; ?>">
                                                    <td width="95%" ><a href="<?php echo CAMINHO_ARQUIVOS."CAT".$valores2['CAT']=$objUltimasAps->preencheZero("E", 4, $valores2['CAT'])."/".$arquivo=$objUltimasAps->preencheZero("E", 4, $valores2['ARQ']).".".$valores2['EXT']?>"><?php echo $valores2['NOM'];?></a></td>
                                                    <td width="5%"  ><a href="javascript:excluir('T0016','T0016/home&cod=<?php echo $valores['APCodigo']; ?>&path=<?php echo $valores2['CAT']=$objUltimasAps->preencheZero("E", 4, $valores2['CAT'])?>','T008_T055','T055_codigo','<?php echo $valores2['ARQ']?>')" title="Excluir" class="excluir"></a></td>
                                                </tr>
                                            <?php }?>
                                                <!-- Caixa Dialogo Excluir -->
                                            </table>
                                        </td>
                                        <td>
                                            <?php echo $valores['Despesa']?>
                                        </td>    
                                        <td>
                                            <?php echo $valores['StatusCod'].' - '.$valores['Status']?>
                                        </td>    
                                </tr>
                                <?php }?>
                        </tbody>
                </table>
            </span>
        </div>
    </div>
</div>

<?php
/* -------- Controle de versões - ultimas.php --------------
 * 1.0.0 - 13/09/2011 - Alexandre --> Liberada versao inicial
 */
?>