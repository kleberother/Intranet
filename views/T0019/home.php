<?php
//Chama classes

//
$objT054 = new models_T0019();
$T054    = $objT054->listaT054();



$user = $_SESSION['user'];

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0019/home" class="active">Listar</a></li>
                <li><a href="?router=T0019/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="conteudo">
    <span class="lista_itens">
	<table class="ui-widget ui-widget-content">
		<thead>
                    <tr class="ui-widget-header ">
                        <th>Texto              </th>
                        <th>Tempo de Publicação</th>
                        <th width="12%">Ações              </th>
                    </tr>
		</thead>
		<tbody>
                    <?php foreach($T054 as $campos=>$valores){
                        $dt_inicial    = $valores['P0019_T054_DTI'];
                        $val_ini           = explode(" ",$dt_inicial);
                        $date_ini          = explode("-",$val_ini[0]);
                        $dt_inicial_format = $date_ini[2]."/".$date_ini[1]."/".$date_ini[0];

                        $dt_final    = $valores['P0019_T054_DTF'];
                        $val_fim           = explode(" ",$dt_final);
                        $date_fim          = explode("-",$val_fim[0]);
                        $dt_final_format = $date_fim[2]."/".$date_fim[1]."/".$date_fim[0];
                    ?>
                    <tr class="dados">
                        <td><?php echo ($valores['P0019_T054_COD']);?> - <?php echo ($valores['P0019_T054_TEX']);?></td>
                        <td><?php echo "de ".$dt_inicial_format." ".($valores['P0019_T054_HOI'])." até ".$dt_final_format." ".($valores['P0019_T054_HOF']);?></td>
                        <td class="acoes">
                            <span class="lista_acoes">
                            <ul>
                                <li class="ui-state-default ui-corner-all" title="Detalhes" ><a href="?router=T0019/detalhe&cod=<?php echo ($valores['P0019_T054_COD']);?>"  class="ui-icon ui-icon-search" id="" ></a></li>
                                <li class="ui-state-default ui-corner-all" title="Alterar"  ><a href="?router=T0019/altera&cod=<?php echo ($valores['P0019_T054_COD']);?>"   class="ui-icon ui-icon-pencil" id="" ></a></li>
                                <li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0019','T0019/home','T054_avisos','T054_codigo',<?php echo ($valores['P0019_T054_COD']);?>)"   class="ui-icon ui-icon-closethick"></a></li>                            </ul>
                            </span>
                        </td>
                    </tr>
                    <?php }?>
                <!-- Caixa Dialogo Excluir -->
                <div id="dialog-confirm" title="Mensagem!" style="display:none">
                    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja excluir este item?</p>
                </div>
		</tbody>
	</table>
    </span>
</div>