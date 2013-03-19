<?php
$user = $_SESSION['user'];
//Chama classes

//Classe para APS
$objAp      =   new models_T0016();
$Ap         =   $objAp->selecionaAPMon();
$cod        =   $_POST['T008_codigo'];
if (!is_null($cod))
{
    $tabela     =   "T008_approval";
    $delim      =   "T008_codigo = ".$cod;
    $objAp->altera($tabela, $_POST, $delim);
    header("location:?router=T0016/monitora");
}
?>
<!-- Caixa de Upload-->
<script src="template/js/interno/T0016/status.js"></script>
<div id="dialog-confirm" title="Status" style="display:none">
	<p class="validateTips">Selecione para alterar o status!</p>
        <span class="form-input">
	<form action="?router=T0016/monitora" method="post" id="form-status"  enctype="form-data">
	<fieldset>
                <label class="label">Status</label>
                <select                 name="T008_status"  id="tp_codigo" class="form-input-select">
                <?php
                    if ($status == 0)
                    {
                        echo "<option value='0' selected='selected'>1 - Digitada</option>";
                    }
                    else
                    {
                        echo "<option value='0'>1 - Digitada</option>";
                    }
                    if ($status == 1)
                    {
                        echo "<option value='1' selected='selected'>2 - Conferida (Recebedor)</option>";
                    }
                    else
                    {
                        echo "<option value='1'>2 - Conferida (Recebedor)</option>";
                    }
                    if ($status == 22)
                    {
                        echo "<option value='22' selected='selected'>3 - Aprovada (Gestor)</option>";
                    }
                    else
                    {
                        echo "<option value='22'>3 - Aprovada (Gestor)</option>";
                    }
                    if ($status == 33)
                    {
                        echo "<option value='33' selected='selected'>4 - Conferido Impostos (Capinha)</option>";
                    }
                    else
                    {
                        echo "<option value='33'>4 - Conferido Impostos (Capinha)</option>";
                    }
                    if ($status == 44)
                    {
                        echo "<option value='44' selected='selected'>5 - Lançada (RMS)</option>";
                    }
                    else
                    {
                        echo "<option value='44'>5 - Lançada (RMS)</option>";
                    }
                    if ($status == 55)
                    {
                        echo "<option value='55' selected='selected'>6 - Provisionada</option>";
                    }
                    else
                    {
                        echo "<option value='55'>6 - Provisionada</option>";
                    }
                    if ($status == 66)
                    {
                        echo "<option value='66' selected='selected'>7 - Rejeitada</option>";
                    }
                    else
                    {
                        echo "<option value='66'>7 - Rejeitada</option>";
                    }
                ?>
                </select>
        </fieldset>
	</form>
        </span>
</div>


<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0016/home">Listar</a></li>
                <li><a href="?router=T0016/novo">Novo</a></li>
                <?php
                if (($user == 'jnova') || ($user == 'msasanto') || ($user == 'cmlima') || ($user == 'aribeiro') || ($user == 'gssilva'))
                 echo "<li><a href='?router=T0016/monitora' class='active'>Visualizar Antigas</a></li>";

                 echo "<li><a href='?router=T0016/painel'>Painel de Aprovações</a></li>";
                ?>
                <li><a href="?router=T0016/fluxo">Fluxo AP</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Filtro Dinâmico</a></li>
<!--        <li><a href="#tabs-2">Filtro por Campos</a></li>-->
    </ul>
    <div id="tabs-1">
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
<!--    <div id="tabs-2">
        <form action="#">
        <table class="form-inpu-tab">
            <thead>
                <tr>
                    <th><label>N° AP:</label></th>
                    <th><label>Nota Fiscal:</label></th>
                    <th><label>CNPJ:</label></th>
                    <th><label>Status:</label></th>
                    <th><label>Registros:</label></th>
                </tr>
                <tr>
                    <td><input type="text"  name="num_ap"   value="<?php //   echo $num_ap ?>" /></td>
                    <td><input type="text"  name="nf"       value="<?php //   echo $nf ?>"  /></td>
                    <td><input type="text"  name="cnpj"     value="<?php //   echo $cnpj ?>"  /></td>
                    <td>
                        <select name="status" id="status">
                            <?php
//                                if ($status == 0)
//                                {
//                                    echo "<option value='0' selected='selected'>1 - Digitada</option>";
//                                }
//                                else
//                                {
//                                    echo "<option value='0'>1 - Digitada</option>";
//                                }
//                                if ($status == 1)
//                                {
//                                    echo "<option value='1' selected='selected'>2 - Conferida (Recebedor)</option>";
//                                }
//                                else
//                                {
//                                    echo "<option value='1'>2 - Conferida (Recebedor)</option>";
//                                }
//                                if ($status == 2)
//                                {
//                                    echo "<option value='2' selected='selected'>3 - Aprovada (Gestor)</option>";
//                                }
//                                else
//                                {
//                                    echo "<option value='2'>3 - Aprovada (Gestor)</option>";
//                                }
//                                if ($status == 3)
//                                {
//                                    echo "<option value='3' selected='selected'>4 - Conferido Impostos (Capinha)</option>";
//                                }
//                                else
//                                {
//                                    echo "<option value='3'>4 - Conferido Impostos (Capinha)</option>";
//                                }
//                                if ($status == 4)
//                                {
//                                    echo "<option value='4' selected='selected'>5 - Lançada (RMS)</option>";
//                                }
//                                else
//                                {
//                                    echo "<option value='4'>5 - Lançada (RMS)</option>";
//                                }
//                                if ($status == 5)
//                                {
//                                    echo "<option value='5' selected='selected'>6 - Provisionada</option>";
//                                }
//                                else
//                                {
//                                    echo "<option value='5'>6 - Provisionada</option>";
//                                }
//                                if ($status == 6)
//                                {
//                                    echo "<option value='6' selected='selected'>7 - Rejeitada</option>";
//                                }
//                                else
//                                {
//                                    echo "<option value='6'>7 - Rejeitada</option>";
//                                }
//                                if ($status == 9)
//                                {
//                                    echo "<option value='9' selected='selected'>Todos</option>";
//                                }
//                                else
//                                {
//                                    echo "<option value='9'>Todos</option>";
//                                }
                            ?>
                        </select>
                    </td>
                    <td><input type="text" name="registros" id="registros" size="3" value="50" /></td>
                </tr>
            </thead>
        </table>
        </form>
    </div>-->
</div>
<div id="conteudo">
    <span class="lista_itens">
	<table class="ui-widget ui-widget-content">
		<thead>
			<tr class="ui-widget-header ">
                            <th width="6%">AP N°      </th>
                            <th width="9%">Nota Fiscal</th>
                            <th width="5%">Série      </th>
                            <th width="13%">CNPJ/CPF   </th>
                            <th>Fornecedor </th>
                            <th>Satus      </th>
                            <th>Usuário    </th>
                            <th>Arquivos   </th>
                            <th width="9%">Ações      </th>
			</tr>
		</thead>
		<tbody>
                        <?php foreach($Ap as $campos=>$valores){
                        $cnpj              = $valores['CGC'];
                        $array_cnpj        = str_split($cnpj);
                        $cnpj_new          = $array_cnpj[0].$array_cnpj[1].".".$array_cnpj[2].$array_cnpj[3].$array_cnpj[4]
                                             .".".$array_cnpj[5].$array_cnpj[6].$array_cnpj[7]."/".$array_cnpj[8].$array_cnpj[9]
                                             .$array_cnpj[10].$array_cnpj[11]."-".$array_cnpj[12].$array_cnpj[13];                            

                        if ($valores['STA'] == 0)
                        {
                            $status = "1 - Digitada";
                        }
                        else if ($valores['STA'] == 1)
                        {
                            $status = "2 - Conferida (Recebedor)";
                        }
                        else if ($valores['STA'] == 22)
                        {
                            $status = "3 - Aprovada (Gestor)";
                        }
                        else if ($valores['STA'] == 33)
                        {
                            $status = "4 - Conferido Impostos (Capinha)";
                        }
                        else if ($valores['STA'] == 44)
                        {
                            $status = "5 - Lançada (RMS)";
                        }
                        else if ($valores['STA'] == 55)
                        {
                            $status = "6 - Provisionada";
                        }
                        else
                        {
                            $status = "7 - Rejeitada";
                        }

                        ?>
			<tr class="dados">
				<td><?php echo ($valores['COD']);?></td>
				<td><?php echo ($valores['NNF']);?></td>
				<td><?php echo ($valores['SER']);?></td>
				<td><?php echo $cnpj_new ;?></td>
				<td><?php echo ($valores['RAZ']);?></td>
				<td><?php echo ($status);?></td>
				<td><?php echo ($valores['LOG']);?></td>
                                <td>
                                    <table class="list-iten-arquivos">
                                        <thead>
                                        <?php $Arq = $objAp->selecionaArquivos($valores['COD']); foreach($Arq  as  $campos=>$valores2){
                                             if( $cont%2 == 0)
                                                    $cor = "line_color";
                                             else
                                                    $cor = "";
                                             $cont++;
                                            ?>
                                            <tr class="<?php echo $cor; ?>">
                                                <td width="95%" ><a target="_blank" href="<?php echo CAMINHO_ARQUIVOS."CAT"?><?php echo $valores2['CAT']=$objAp->preencheZero("E", 4, $valores2['CAT'])."/".$valores2['ARQ']=$objAp->preencheZero("E", 6, $valores2['ARQ']).".".$valores2['EXT']?>"><?php echo $valores2['NOM'];?></a></td>
                                                <td width="5%"  ><a href="javascript:excluir('T0016','T0016/monitora','T008_T055','T055_codigo',<?php echo ($valores2['CAT']);?>,'',0,1)" title="Excluir" class="excluir"></a></td>
                                            </tr>
                                        <?php }?>
                                        </thead>
                                    </table>
                                </td>
                                <td class="acoes">
                                    <span class="lista_acoes">
                                        <ul>
                                            <li class="ui-state-default ui-corner-all" title="Imprimir"  ><a href="?router=T0016/pdf&cod=<?php echo ($valores['COD']);?>"                                             class="ui-icon ui-icon-print"                target="_blank" ></a></li>
  
                                            <li class="ui-state-default ui-corner-all" title="Alterar Status"><a href="javascript:status(<?php echo ($valores['COD']);?>)" class="ui-icon ui-icon-refresh" ></a></li>
                                        </ul>
                                    </span>
                                </td>
			</tr>
                        <?php }?>
		</tbody>
	</table>
    </span>
</div>