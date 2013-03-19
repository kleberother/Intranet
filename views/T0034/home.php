<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 14/09/2011 por Rodrigo Alfieri
 * Descrição: Programa para controle dos painéis digitais das lojas   
 * Entradas:   
 * Origens:   Menu Sistema
           
***************************************************************************/
$obj = new models_T0034();

$Painel                 =   $_POST['T078_codigo'];
$Loja                   =   $_POST['T006_codigo'];

//Retorna Paineis para Filtro
$FiltroPainel           =   $obj->retornaPaineis();
//Retorna Lojas para Filtro 
$FiltroLoja             =   $obj->listaLojas();
//Retorna Paineis
$Paineis                =   $obj->retornaPaineis($Painel,$Loja);

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0034/home" class="active" >Painéis</a></li>
                <li><a href="?router=T0034/novo"                >Novo   </a></li>
            </ul>
        </span>
    </div>
</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Filtro de Panéis</a></li>
    </ul>
    <div id="tabs-1">
        <form action="" method="post" id="formCad">
            <span  class="form-input">
                <table class="form-inpu-tab">
                    <thead>
                        <tr>
                            <th width="155px"><label>Filtro Dinâmico</label></th>
                            <th width="155px"><label>Painel</label></th>
                            <th width="155px"><label>Loja</label></th>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="search" value="" id="id_search" />
                            </td>
                            <td>
                                <select name="T078_codigo">
                                    <option value="">Selecione...</option>
                                    <?php foreach($FiltroPainel as $campos => $valores){?>
                                    <option value="<?php echo $valores['Codigo'];?>" <?php echo ($valores['Codigo']==$Painel)?"selected":"";?>><?php echo $obj->preencheZero("E", 3, $valores['Codigo'])." - ".$valores['Descricao'];?></option>
                                    <?php }?>
                                </select>
                            </td>
                            <td>
                                <select name="T006_codigo">
                                    <option value="">Selecione...</option>
                                    <?php foreach($FiltroLoja as $campos=>$valores){?>
                                    <option value="<?php echo $valores['Codigo'];?>" <?php echo ($valores['Codigo']==$Loja)?"selected":"";?>><?php echo $obj->preencheZero("E", 3, $valores['Codigo'])." - ".$valores['Nome'];?></option>                                    
                                    <?php } ?>
                                </select>
                            </td>
                            <td><span class="loading">Carregando...</span></td>
                        </tr>
                    </thead>
                </table>
            </span>   
        <div class="form-inpu-botoes">
            <input type="submit" value="Filtrar" id="Filtrar"/>
        </div>            
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
                            <th>Local    </th>
                            <th>Somente <br>Produtos da Seção    </th>
                            <th width="9%">Ações    </th>
			</tr>
		</thead>
		<tbody>
                        <?php foreach($Paineis as $campos=>$valores){?>                   
			<tr class="dados">
                            <td><?php echo $obj->preencheZero("E", 3, $valores['Codigo'])." - ".$valores['Descricao'];?>    </td>
                            <td><?php echo $obj->preencheZero("E", 3, $valores['TemaCodigo'])." - ".$valores['TemaNome'];?> </td>
                            <td><?php echo $obj->preencheZero("E", 3, $valores['Loja'])." - ".$valores['LojaNome'];?>       </td>
                                <td>
                                    <table>
                                        <?php if(!empty($valores['DeptoCodigo'])){?>
                                            <tr>
                                                <td>Departamento:</td>
                                                <td><?php echo $obj->preencheZero("E", 3, $valores['DeptoCodigo'])." - ".$valores['DeptoDesc'];?></td>
                                            </tr>
                                        <?php }else{?>
                                            <tr>
                                                <td>Sem Local</td>
                                            </tr>    
                                        <?php }if(!empty($valores['SecaoCodigo'])){?>    
                                            <tr>
                                                <td>Seção:</td>
                                                <td><?php echo $obj->preencheZero("E", 3, $valores['SecaoCodigo'])." - ".$valores['SecaoDesc'];?></td>
                                            </tr>
                                            <tr>
                                        <?php }if(!empty($valores['GrupoCodigo'])){?>
                                                <td>Grupo:</td>
                                                <td><?php echo $obj->preencheZero("E", 3, $valores['GrupoCodigo'])." - ".$valores['GrupoDesc'];?></td>
                                            </tr>
                                        <?php }if(!empty($valores['SubGrupoCodigo'])){?>    
                                            <tr>
                                                <td>SubGrupo:</td>
                                                <td><?php echo $obj->preencheZero("E", 3, $valores['SubGrupoCodigo'])." - ".$valores['SubGrupoDesc'];?></td>
                                            </tr>
                                        <?php }?>    
                                    </table>
                                
                                <?php if($valores['SecaoPropria']==0)
                                        $SecaoPropria   =   "Não";
                                    else
                                        $SecaoPropria   =   "Sim";
                                ?>
                                <td><?php echo $SecaoPropria;?></td>
                                <td class="acoes">
                                    <span class="lista_acoes">
                                    <ul>
                                        <li class="ui-state-default ui-corner-all" title="Editar"               ><a href="?router=T0034/altera&cod=<?php echo $valores['Codigo']?>                                                                                                                                                                                                                                                                                                          "   class="ui-icon ui-icon-pencil       "   ></a></li>
                                        <li class="ui-state-default ui-corner-all" title="Associar Produtos"    ><a href="?router=T0034/associar&Painel=<?php echo ($valores['Codigo']);?>"   class="ui-icon ui-icon-plusthick    "   ></a></li>
                                        <li class="ui-state-default ui-corner-all" title="Excluir"              ><a href="javascript:excluir('T0034','T0034/home','T078_painel','T078_codigo',<?php echo ($valores['Codigo']);?>,'',0,2)                                                                                                                                                                                                                                                    "   class="ui-icon ui-icon-closethick   "   ></a></li>
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