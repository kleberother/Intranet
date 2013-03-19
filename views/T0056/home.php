<?php
//Chama classes

//Instancia Classe
$obj            =   new models_T0056();

$Produtos       =   $obj->retornaProdutos();
?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0056/home" class="active" >Listar </a></li>
            </ul>
        </span>
    </div>
</div>
<div id="tabs">
    <ul> 
        <li><a href="#tabs-2">Filtro Dinâmico</a></li>
    </ul>
    <div id="tabs-2">
        <form action="#">
        <table class="form-inpu-tab" >
            <thead>
                <tr>
                    <th width="155px"><label>Filtro</label></th>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="search" value="" id="id_search" />
                    </td>
                    <td><span class="loading">Carregando...</span></td>
                </tr>
            </thead>
        </table>
        </form>
    </div>
</div>
<div id="conteudo">
    <span class="lista_itens">
	<table class="ui-widget ui-widget-content tablesorter" id="tablesorter">
		<thead>
			<tr class="ui-widget-header ">
                            <th width="5%">Código             </th>
                            <th           >Descrição          </th>
                            <th           >Descrição Comercial</th>
                            <th           >Departamento       </th>
                            <th           >Seção              </th>
                            <th           >Grupo              </th>
                            <th           >SubGrupo           </th>
                            <th           >Imagem             </th>
                            <th width="5%">Ações              </th>
			</tr>
		</thead>
		<tbody> <?php $i=1;?>
                        <?php foreach($Produtos as $campos=>$valores) {?>
			<tr class="dados">
				<td><?php echo $obj->preenchezero("E",3,$valores['ProdutoCodigo'])      ."-".   $valores['ProdutoDigito'];?>        </td>
				<td><?php echo $valores['ProdutoDescricao'];?>                                                                      </td>
				<td><?php echo $valores['ProdutoDescComercial'];?>                                                                  </td>
				<td><?php echo $obj->preenchezero("E",3,$valores['DepartamentoCodigo']) ."-".   $valores['DepartamentoDescricao'];?></td>
				<td><?php echo $obj->preenchezero("E",3,$valores['SecaoCodigo'])        ."-".   $valores['SecaoDescricao'];?>       </td>
				<td><?php echo $obj->preenchezero("E",3,$valores['GrupoCodigo'])        ."-".   $valores['GrupoDescricao'];?>       </td>
				<td><?php echo $obj->preenchezero("E",3,$valores['SubGrupoCodigo'])     ."-".   $valores['SubGrupoDescricao'];?>    </td>
				<td>
                                <?php $Arquivo           =   $obj->retornaArquivos($valores['ProdutoCodigo']);
                                      foreach($Arquivo as $campoArq => $valorArq){ ?>
                                <a href="<?php echo CAMINHO_ARQUIVOS."CAT".$obj->preencheZero("E", 4, $valorArq['ArquivoCategoria'])."/".$obj->preencheZero("E", 8, $valorArq['ArquivoCodigo']);?>" target='_blank'>Foto/Imagem</a>
                                <?php }?>
                                </td>
                                <td class="acoes">
                                    <span class="lista_acoes">
                                    <ul>
                                        <li class="ui-state-default ui-corner-all" title="Associar" ><a href="?router=T0056/associar&ProdutoCodigo=<?php echo ($valores['ProdutoCodigo']);?>"                                                class="ui-icon ui-icon-plusthick" ></a></li>
                                    </ul>
                                    </span>
                                </td>
			</tr>
                        <?php $i++; }?>
                </tbody>
	</table>
    </span>
</div>