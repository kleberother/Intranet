<?php
//Chama classes

//Classe para Usuarios
$obj           = new models_T0033();
//Retorna lista de departamentos
$Departamentos = $obj->retornaDepartamentos();
//Captura usuário da session
$user          = $_SESSION['user'];

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0033/home" class="active">Listar</a></li>
                <li><a href="?router=T0033/novo">Novo</a></li>
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
	<table class="ui-widget ui-widget-content" style="font-family: 'Lucida Sans Typewriter';font-size:13px;">
		<thead>
			<tr class="ui-widget-header ">
                                <th>Nome Departamento</th>                                
                                <th>Descrição        </th>                                
				<th width="9%">Ações </th>
			</tr>
		</thead>
		<tbody>
                        <?php
                        function verificaDeptos($CodigoPai, $FilDepartamento)
                        {
                            global $nivel; $nivel ++;
                            $obj    =   new models_T0033();
                            $DptosPai  =   $obj->retornaDepartamentosPai($CodigoPai);                                        
                            foreach($DptosPai   as  $campos =>  $valores)
                            {       
                                if (!empty($valores['PaiDpto']))
                                    $Cascata .= str_repeat("&nbsp",($nivel*4)-4)   ;
                                else
                                    $Cascata  = "" ;  // Raiz pai = NULL
                               
                                echo "<tr class='dados'>";
                                echo "    <td>".$Cascata.$obj->preencheZero("E", 3, $valores['CodigoDpto'])."-".$valores['NomeDpto']."</td>";
                                echo "    <td>".$valores['DescDpto']."</td>";
                                echo "    <td class='acoes'>";
                                echo "        <span class='lista_acoes'>";
                                echo "            <ul>";
                                echo "                <li class='ui-state-default ui-corner-all' title='Alterar'  ><a href='?router=T0033/altera&cod=".$valores['CodigoDpto']."'   class='ui-icon ui-icon-pencil'              ></a></li>";
                                $A  =   '"';
                                echo "                <li class=".$A."ui-state-default ui-corner-all".$A." title=".$A."Excluir".$A."  ><a href=".$A."javascript:excluir('T0033','T0033/home','T077_departamento','T077_codigo',".$valores['CodigoDpto'].",'',0,1)".$A."   class=".$A."ui-icon ui-icon-closethick".$A."></a></li>";
                                echo "            </ul>";
                                echo "        </span>";
                                echo "    </td>";
                                echo "</tr>";
                                
                                $Cascata  = ""                  ;

                                verificaDeptos($valores['CodigoDpto'], $FilDepartamento);
                            }
                            $nivel --;
                        }
                        $CodigoPai      =   NULL    ;
                        $Retorno    =   verificaDeptos($CodigoPai, $FilDepartamento);
                        ?>
		</tbody>
                <!-- Caixa Dialogo Excluir -->
                <div id="dialog-confirm" title="Mensagem!" style="display:none">
                    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja excluir este item?</p>
                </div>              
	</table>
    </span>
</div>