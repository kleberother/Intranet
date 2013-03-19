<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 30/09/2011 por Rodrigo Alfieri
 * Descrição: Tela para associar arquivos aos produtos do Painel
           
***************************************************************************/
$ProdutoCodigo      =   $_GET['ProdutoCodigo'];
$Tabela             =   "T055_T075";

//Instancia Classe
$obj                =   new models_T0056();
//Dados do Arquivo
$Arquivo           =   $obj->retornaArquivos($ProdutoCodigo);
//Retorna quantidade de produto associado para bloquear botão associar
$QtdeAssociado = $obj->retornaQtdeArquivos($ProdutoCodigo);
foreach($QtdeAssociado as $campo=>$valor)
{
    $QtdeProdutosAssociados = $valor['Qtde'];
}

$Produto            =   $obj->retornaProdutos($ProdutoCodigo);
foreach($Produto as $campo=>$valor)
{
    $ProdutoDigito      =   $valor['ProdutoDigito'];
    $ProdutoDescricao   =   $valor['ProdutoDescricao'];
    
}

$Login              =   $_SESSION['user'];

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0056/home">Listar</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="conteudo">
    <span class="lista_itens">
    <span class="form-titulo">
        <p><?php echo "Produto: ".$ProdutoCodigo." - ".$ProdutoDescricao?></p>
    </span>
	<table class="ui-widget ui-widget-content">
		<thead>
			<tr class="ui-widget-header ">
                            <th width="5%" >Código                                  </th>
                            <th            >Nome (para visualizar clique no nome)   </th>
                            <th            >Data Upload                             </th>
                            <th width="5%" >Ações                                   </th>
			</tr>
		</thead>
		<tbody>
                        <?php $i=0; foreach($Arquivo as $campos => $valores){ $i++; ?>
			<tr> 
                            <td><?php echo $obj->preenchezero("E",3,$valores['ArquivoCodigo'])?></td>
                            <td><a href="<?php echo CAMINHO_ARQUIVOS."CAT".$obj->preencheZero("E", 4, $valores['ArquivoCategoria'])."/".$obj->preencheZero("E", 8, $valores['ArquivoCodigo']);?>" target='_blank'><?php echo $valores['ArquivoNome'];?></a></td>
                            <td><?php echo $obj->formataDataView($valores['ArquivoDtUpload']);?></td>
                            <td class="acoes">
                                <span class="lista_acoes">
                                <ul>
                                    <li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0056','T0056/associar','T055_T075','T055_codigo,T075_codigo','<?php echo $valores['ArquivoCodigo'].",".$ProdutoCodigo;?>','',0,1)"   class="ui-icon ui-icon-closethick"></a></li>                                   
                                </ul>
                                    
                                </span>
                            </td>
			</tr>
                        <?php }if($i==0){?> 
                        <tr>
                                <td colspan="5"><center>Não Existe nenhuma imagem Associada a este Produto.</center></td>
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
<div id="formulario">
    <span class="form-titulo">
        <p>Associar uma Imagem a este Produto</p>
    </span>
    <span class="form-input">
    <form action="?router=T0056/js.upload" method="post" id="form-upload"  enctype="multipart/form-data">
    <input type="hidden"    name="T056_codigo"  value="14"                          />
    <input type="hidden"    name="T075_codigo"  value="<?php echo $ProdutoCodigo;?>"/>
    <input type="hidden"    name="T075_digito"  value="<?php echo $ProdutoDigito;?>"/>
    <input type="hidden"    name="T004_login"   value="<?php echo $Login;?>"        />
    <table>
        <tr>
            <td><label class="label">Nome*</label></td>
        </tr>
        <tr>
            <td><input type="text" name="T055_nome"              class="validate[required] form-input-text" value="<?php echo $ProdutoDescricao; ?>" <?php echo ($QtdeProdutosAssociados>=1)?"disabled":""?>/></td>
        </tr>
        <tr>
            <td><label class="label">Escolha uma Imagem*</label></td>
        </tr>
        <tr>
            <td><input type="file" name="Arquivo"   id="arquivo" class="validate[required] form-input-text" <?php echo ($QtdeProdutosAssociados>=1)?"disabled":""?>/></td>
        </tr>
    </table>
        <div class="form-inpu-botoes">
            <input type="submit" value="Associar" <?php echo ($QtdeProdutosAssociados>=1)?"disabled":""?> />
        </div>
    </form>
    </span>
</div>
<?php
/* -------- Controle de versões - models/T0034.php --------------
 * 1.0.0 - 30/09/2011   --> Liberada a versão
*/
?>