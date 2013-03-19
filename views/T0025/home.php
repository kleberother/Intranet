<?php
//Chama classes

//
$objT026 = new models_T0025();
//$limite  = $_GET["limite"];
//if($limite == "")
//    $limite = 10;

$T026    = $objT026->listaT026();
$user    = $_SESSION['user'];

?>
<script src="template/js/interno/T0025/home.js"></script>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0025/home" class="active">Listar</a></li>
                <li><a href="?router=T0025/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-2">Filtro Dinâmico</a></li>
    </ul>
    <div id="tabs-2">
        <form action="" method="post" id="formCad">
        <table class="form-inpu-tab">
            <thead>
                <tr>
                    <th width="155px"><label>Filtro</label></th>
<!--                    <th><label>N° Registros</label></th>-->
                </tr>
                <tr>
                    <td>
                        <input type="text" name="search" value="" id="id_search" /><br/>
                        <span class="loading">Carregando...</span>
                    </td>
<!--                    <td><input type="text" name="limite" value="10" id="limite" /></td>-->
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
                        <th width="9%">RMS Código  </th>
                        <th>Fornecedor</th>
                        <th width="13%">CPF / CNPJ  </th>
                        <th width="12%">Ações</th>
                    </tr>
		</thead>
		<tbody>
                    <?php foreach($T026 as $campos=>$valores){
                        $cnpj              = $valores['CNPJxCPF'];
                        $array_cnpj        = str_split($cnpj);
                        $cnpj_new          = $array_cnpj[0].$array_cnpj[1].".".$array_cnpj[2].$array_cnpj[3].$array_cnpj[4]
                                             .".".$array_cnpj[5].$array_cnpj[6].$array_cnpj[7]."/".$array_cnpj[8].$array_cnpj[9]
                                             .$array_cnpj[10].$array_cnpj[11]."-".$array_cnpj[12].$array_cnpj[13];                        
                    ?>
                    <tr class="dados">
                        <td><?php echo ($valores['RMSCodigo']."-".$valores['RMSDigito']);?></td>
                        <td><?php echo ($valores['Codigo'])." - ".($valores['RazaoSocial']);?></td>
                        <td><?php echo $cnpj_new;?></td>
                        <td class="acoes">
                            <span class="lista_acoes">
                                <ul>
                                    <li class="ui-state-default ui-corner-all" title="Associar"  ><a href="?router=T0025/associar&cod=<?php  echo ($valores['Codigo']);?>&nom=<?php echo ($valores['RazaoSocial']);?>" class="ui-icon ui-icon-plusthick" id="" ></a></li>
                                    <li class="ui-state-default ui-corner-all" title="Contatos" ><a href="?router=T0025/contato&cod=<?php echo ($valores['Codigo']);?>" class="ui-icon ui-icon-person" id="" ></a></li>
                                    <li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0025','T0025/home','T026_fornecedor','T026_codigo',<?php echo ($valores['Codigo']);?>)"   class="ui-icon ui-icon-closethick"></a></li>
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