<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: #/#/# por Rodrigo Alfieri
 * Descrição: Programa para controle das APs (autorizacao de pagamentos), a qual visa formalizar os pagamentos referentes à prestação de serviços
 *            e/ou compra de equipamentos/suprimentos   
 * Entradas:   
 * Origens:   Menu Sistema
           
**************************************************************************
*/

$user         = $_SESSION['user'];
$tipo         = $_REQUEST['tipo'];
//Chama classes
//Classe para APS
$objAp        =  new models_T0016($conn);

if ($_GET['Msg']==1)
{
    echo "<script>show_stack_bottomleft(false, 'Alerta!', 'Para verificar as AP(s) que estão fora do prazo, utilize o filtro Status: Fora do Prazo!');</script>";
}

// guarda filtros utilizados
$FilAp   = $_POST['FilAp'];
$FilNf   = $_POST['FilNf'];

echo $FilAp;
echo $FilNf;

//procura se há mais de um grupo de workflow associado ao usuário
$dadoGrupoWF = $objAp->GruposWorkflowUsuario($user);

//Classe para TIPOS DE ARQUIVOS
$TArq         =  $objAp->selecionaTipoArquivo();

//Classe para lista de Grupos de Workflow
$GruposWF =  $objAp->listaWF();

?>
<!-- Filtro Dinâmico -->
<script src="template/js/interno/T0016/home.js"></script>
<!-- Caixa Dialogo Aprovar -->
<script src="template/js/interno/T0016/aprovar.js"></script>
<div id="dialog-transmissao" title="Mensagem!" style="display:none">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja aprovar essa(s) AP(s)?</p>
</div>
<div id="dialog-carregando" title="" style="display:none">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Aguarde Aprovando AP(s)</p>
</div>
<div id="dialog-tranferindo" title="" style="display:none">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Aguarde Transferindo a AP</p>
</div>
<!-- Caixa de Cancelamento-->
<script src="template/js/interno/T0016/cancelar.js"></script>
<div id="dialog-cancelar" title="Mensagem!" style="display:none">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja cancelar esta AP?</p>
</div>
<!-- Caixa de Transferir Fluxo -->
<script src="template/js/interno/T0016/transferir.js"></script>
<div id="dialog-transferir" title="Mensagem!" style="display:none">
    <p>Essa opção irá transferir essa AP do seu Grupo de Workflow para o grupo no qual a AP pertence.</p>
    <form action="" id="frm_grupos">
        <fieldset>
            <label class="label">Escolha o Grupo de Workflow</label>

            <select name="T008_T026T059_T059_codigo" class="grupoWF form-input-text-table" style="width: 300px;">
                <option value="">Selecione...</option>
                <?php foreach($GruposWF as $campos=>$valores){                                                                                                                                                ?>
                   <option value="<?php echo $valores['COD']?>"><?php echo $valores['COD']=$objAp->preencheZero("E",3,$valores['COD'])?> - <?php echo $valores['NOM']?></option>
                <?php }?>
            </select>
        </fieldset>
    </form>
</div>
<!-- Caixa de Upload-->
<script src="template/js/interno/T0016/upload.js"></script>
<div id="dialog-upload" title="Upload" style="display:none">
	<p    class="validateTips">Selecione um tipo e um arquivo para carregar no sistema!</p>
        <span class="form-input">
	<form action="?router=T0016/js.upload" method="post" id="form-upload"  enctype="multipart/form-data">
	<fieldset>
                <label class="label">Tipo de Arquivo*</label>
                <select                 name="T056_codigo"  id="tp_codigo" class="form-input-select">
                <?php foreach($TArq as $campos=>$valores){?>
                    <option value="<?php echo $valores['COD']?>"><?php echo ($valores['NOM'])?></option>
                <?php }?>
                </select>
                <label class="label">Escolha o Arquivo*</label>
                <input type="file"      name="P0016_arquivo"      id="arquivo" class="form-input-text"   />
                <input type="hidden"    name="T055_nome"            value=""                             />
                <input type="hidden"    name="T055_desc"            value=""                             />
                <input type="hidden"    name="T055_dt_upload"       value=""                             />
                <input type="hidden"    name="T004_login"           value="<?php echo $user?>"           />
                <input type="hidden"    name="T057_codigo"          value=""                             />
                <input type="hidden"    name="T059_codigo"          value=""                             />
                <input type="hidden"    name="T008_codigo"          value=""      id="codap"             />
                <!-- Tipo Processo (Approval/Aprovação-->
                <input type="hidden"    name="T061_codigo"          value="1"                            />
        </fieldset>
	</form>
        </span>
</div>
<!-- FIM Caixa de Upload-->
<div id="dialog-data-vencimento" title="Data de Vencimento em Branco!" style="display:none">
	<p class="validateTips pVencimento"></p>     
            <label class="label">Data Vencimento*</label>
                <input type="text" name="T008_nf_dt_vencto"         id="DataVencto"           class="data" />
</div>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0016/home" class="active">Listar</a></li>
                <li><a href="?router=T0016/novo">Novo</a></li>
                <?php
                if (($user == 'jnova') || ($user == 'msasanto') || ($user == 'cmlima') || ($user == 'aribeiro') || ($user == 'gssilva'))
                 echo "<li><a href='?router=T0016/monitora'>Visualizar Antigas</a></li>";

                if (($user == 'rrocha') || ($user == 'fcolivei') || ($user == 'msasanto') || ($user == 'cmlima') || ($user == 'ralfieri') || ($user == 'rcsilva') || ($user == 'lolive') || ($user == 'ctlima') || ($user == 'mlsilva') || ($user == 'rcsouza'))
                 echo "<li><a href='?router=T0016/painel'>Painel de Aprovações</a></li>";
                ?>
                <li><a href="?router=T0016/fluxo">Fluxo AP</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Filtro</a></li>
    </ul>
    <div id="tabs-1">        
        <form action="#" method="post">
        <table class="form-inpu-tab">
            <thead>
                <tr>
                    <th width="1px"><label>Status</label></th>
                    <th width="1px"><label>Filtro</label></th>
                    <th width="100px"><label>Qtde Registros</label></th>
                </tr>
                <tr>
                    <td>
                        <select id="aps" name="tipo">
                            <option value="0">Selecione...                      </option>
                            <option value="1">Aguardando minha Aprovação        </option>
                            <option value="2">Minhas digitadas (não aprovadas)  </option>
                            <option value="3">Anteriores à mim                  </option>
                            <option value="4">Posteriores à mim                 </option>
                            <option value="5">Finalizadas                       </option>
                            <option value="6">Canceladas                        </option>
                            <option value="7">Fora do Prazo                     </option>
                            <option value="8">Todos                             </option>
                        </select>
                        
                    </td>
                    <td>
                        <input width="155px" type="text" name="search" value="" id="id_search" />
                    </td>
                    <td>
                       <select id="FilRegistros" name="FilRegistros" class="CampoFiltro">
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="">Todos</option>
                        </select>
                    </td>
                        
                </tr>
                <tr>
                    <th width="5px"><label>AP</label></th>
                    <th width="5px"><label>NF</label></th>
                    <th width="200px"><label>Fornecedor (Contém)</label></th>
                    <th width="200px"><label>CNPJ/CPF (Contém)</label></th>
                <tr>
                <tr>
                    <td>
                        <input size="5" type="text" name="FilAp" id="FilAp" class="CampoFiltro" value="" />
                    </td>
                    <td>
                        <input size="8" type="text" name="FilNf" id="FilNf" class="CampoFiltro" value="" />
                    </td>
                    <td>
                        <input size="16" type="text" name="FilFornecedor" id="FilFornecedor" class="CampoFiltro" value="" />
                    </td>
                    <td>
                        <input size="16" type="text" name="FilCNPJ" id="FilCNPJ" class="CampoFiltro" value="" />
                    </td>
                </tr>
                </tr>    
                    <th width="2050px"><label>Vencimento Inicial</label></th>
                    <th width="2050px"><label>Vencimento Final</label></th>
                    <th width="250px"><label>Valor Inicial</label></th>
                    <th width="250px"><label>Valor Final</label></th>                    
                    
                </tr>
                    <td>
                       <input  size="6"  type="text" id="dt_inicial" class="FilVencimentoInicial CampoFiltro" name="VencimentoInicial" value="" />

                    </td>
                    <td>
                        <input size="6"  type="text" id="dt_final" class="FilVencimentoFinal CampoFiltro" name="VencimentoFinal" value=""/>
                    </td>                    
                    <td>
                        <input size="10" type="text" name="ValorInicial" id="FilValorInicial"   class="validate[required] valor CampoFiltro" />
                    </td>
                    <td>
                        <input size="10" type="text" name="ValorFinal" id="FilValorFinal"   class="validate[required] valor CampoFiltro" />
                    </td>
                </tr>
                    
            </thead>
        </table>
        <span class="form-input">
        <div class="form-inpu-botoes">
            <button type="button" id="btnFiltrar">Filtrar</button>
            <button type="button" id="btnAprovarTodos">Aprovar Selecionados</button>
        </div>   
        </span>
        <div class="textarea">
            <span id="carregando"></span>
            <span class="loading">Aguarde Carregando...</span>
        </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="template/js/tablesorter/jquery.tablesorter.js"></script>
<script></script>
<div id="conteudo">
    <span class="lista_itens">
	<table>
		<thead>
			<tr class="ui-widget-header ">
                            <th width="2%"><input type="checkbox" 
                                                  name="selecionaTodos" 
                                                  id="selecionaTodos" 
                                                  value="1" 
                                                  onmouseover ='show_tooltip_alert("","Clique aqui para selecionar todas APs", true);tooltip.pnotify_display();' 
                                                  onmousemove ='tooltip.css({"top": event.clientY+12, "left": event.clientX+12});' 
                                                  onmouseout  ='tooltip.pnotify_remove();'>
                            </th>
                            <th width="6%">AP N°                    </th>
                            <th width="9%">Nota Fiscal<br/>Série    </th>
                            <th width="13%">Fornecedor<br/>CNPJ/CPF </th>
                            <th width="8%">Elaborado<br/>por        </th>
                            <th width="13%" >Última<br/>Etapa        </th>
                            <th>Loja Faturada                       </th>
                            <th width="8%">Vencimento               </th>
                            <th width="9%">Valor                    </th>
                            <th>Arquivos                            </th>
                            <th width="9%">Ações                    </th>
                        
			</tr>
		</thead>
                <tbody class="campos"></tbody>
	</table>
    </span>
        <span class="form-input">
        <div class="form-inpu-botoes">
        </div>   
        </span>    

</div>

<?php
/* -------- Controle de versões - home.php --------------
 * 1.0.0 - #/#/#                  --> Liberada versao sem controle de versionamento
 * 1.0.1 - 14/09/2011 - Alexandre --> Alterados os filtros, para que sejam considerados novos campos, a busca é feita dinamicamente atraves 
 *                                    do js.busca
 * 
*/
?>