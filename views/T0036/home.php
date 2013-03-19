<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 16/09/2011 por Jorge Nova                              
 * Descrição: Arquivo lista todos os templates cadastrados para tvs digitais
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/

// GRAVA SESSÃO DE UM USUÁRIO EM UMA VARIAVEL
$user       = $_SESSION['user'];

// INSTANCIA OBJETO DA CLASSE T0036
$obj        = new models_T0036();

// RETORNA DADOS DE TEMPLATE
$Templates  = $obj->retornaTemplates();


?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0036/home" class="active">Listar</a></li>
                <li><a href="?router=T0036/novo">Novo</a></li>
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
				<th>Nome</th>
				<th>Descrição</th>
				<th width="9%">Ações    </th>
			</tr>
		</thead>
		<tbody>
                        <?php foreach($Templates as $campos=>$valores){?>
			<tr class="dados">
				<td><?php echo ($valores['Codigo']);?> - <?php echo ($valores['Nome']);?></td>
				<td><?php echo ($valores['Descricao']);?></td>
                                <td class="acoes">
                                    <span class="lista_acoes">
                                    <ul>
                                        <li class="ui-state-default ui-corner-all" title="Alterar"  ><a href="?router=T0036/altera&codigo=<?php echo ($valores['Codigo']);?>"  class="ui-icon ui-icon-pencil"              ></a></li>
                                        <li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0036','T0036/home','T076_template','T076_codigo',<?php echo ($valores['Codigo']);?>)"   class="ui-icon ui-icon-closethick"></a></li>
                                    </ul>
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

<?php
/* -------- Controle de versões - T0036.php --------------
 * 1.0.0 - 16/09/2011 - Jorge --> Liberada versao inicial
 *                                
 */
?>