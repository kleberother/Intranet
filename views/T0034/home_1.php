<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 14/09/2011 por Rodrigo Alfieri
 * Descrição: Programa para controle dos painéis digitais das lojas   
 * Entradas:   
 * Origens:   Menu Sistema
           
***************************************************************************/
$obj = new models_T0034();

$Dados  =   $obj->retornaPaineis();

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0034/home" class="active" >Painéis</a></li>
                <li><a href="?router=T0034/novo"                >Novo   </a></li>
                <li><a href="?router=T0034/tema"                >Temas  </a></li>                
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
        <table class="form-inpu-tab">
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
	<table class="ui-widget ui-widget-content">
		<thead>
			<tr class="ui-widget-header ">
                            <th>Painel</th>
                            <th>Tema     </th>
                            <th>Loja    </th>
                            <th>Departamento    </th>
                            <th>SecaoPropria    </th>
                            <th width="9%">Ações    </th>
			</tr>
		</thead>
		<tbody>
                        <?php foreach($Dados as $campos=>$valores){?>
			<tr class="dados">
                            <td><?php echo $obj->preencheZero("E", 3, $valores['Codigo'])." - ".$valores['Descricao'];?></td>
                            <td><?php echo $obj->preencheZero("E", 3, $valores['TemaCodigo'])." - ".$valores['TemaNome'];?></td>
				<td><?php echo $valores['Loja'];?></td>
                                <td><?php echo $obj->preencheZero("E", 3, $valores['DeptoCodigo'])." - ".($valores['DeptoDesc']);?></td>
                                <?php if($valores['SecaoPropria']==0)
                                        $SecaoPropria   =   "Não";
                                    else
                                        $SecaoPropria   =   "Sim";
                                ?>
                                <td><?php echo $SecaoPropria;?></td>
                                <td class="acoes">
                                    <span class="lista_acoes">
                                    <ul>
                                        <li class="ui-state-default ui-corner-all" title="Editar"  ><a href="?router=T0034/altera"  class="ui-icon ui-icon-pencil"              ></a></li>
                                        <li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0034','T0034/home','T078_painel','T078_codigo',<?php echo ($valores['Codigo']);?>,'',0,1)"   class="ui-icon ui-icon-closethick"></a></li>
                                    </ul>
                                    </span>
                                </td>
			</tr>
                        <?php }?>
		</tbody>
	</table>
    </span>
</div>
<!-- Caixa Dialogo Excluir -->
<div id="dialog-confirm" title="Mensagem!" style="display:none">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja excluir este item?</p>
</div>
<?php
/* -------- Controle de versões - home.php --------------
 * 1.0.0 - 14/09/2011   --> Liberada a versão
*/
?>