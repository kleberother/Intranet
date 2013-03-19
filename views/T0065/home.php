<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 21/11/2011 por Jorge Nova                              
 * Descrição: Lista todas as lojas cadastradas
 * Entrada:   
 * Origens:   
           
**************************************************************************
 */

//Instancia Classe
$obj   =   new models_T0065();

$Lojas =  $obj->retornaLojas(); 

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0065/home" class="active" >Listar </a></li>                
<!--                <li><a href="?router=T0065/novo">Novo </a></li>                -->
            </ul>
        </span>
    </div>
</div>
<div id="conteudo">
    <span class="lista_itens">
	<table class="ui-widget ui-widget-content tablesorter" id="tablesorter">
		<thead>
			<tr class="ui-widget-header ">
                            <th           >Loja     </th>
                            <th           >Segmento </th>
                            <th width="5%">Ações    </th>
			</tr>
		</thead>
		<tbody>
                <?php foreach($Lojas as $campos=>$valores) {?>
                    <tr class="dados">
                        <td><?php echo $obj->preenchezero("E",3,$valores['CodigoLoja'])." - ".$valores['NomeLoja'];?></td>
                        <td><?php echo $obj->preenchezero("E",3,$valores['CodigoSegmento'])." - ".strtoupper($valores['NomeSegmento'])  ;?></td>
                        <td class="acoes">
                            <span class="lista_acoes">
                            <ul>
                                <li class="ui-state-default ui-corner-all" title="Associar" ><a href="?router=T0065/associar&codigo=<?php echo ($valores['CodigoLoja']);?>&nome=<?php echo $valores['NomeLoja']; ?>" class="ui-icon ui-icon-plusthick" ></a></li>
                            </ul>
                            </span>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
	</table>
    </span>
</div>


