<?php
//Pega parametros
$user         = $_SESSION["user"];
$objPosto     = new models_T0027();
$Concorrentes = $objPosto->retornaPostosConcorrentes();

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0027/home" class="active">Listar</a></li>
                <li><a href="?router=T0027/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Filtro Dinâmico</a></li>
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
</div>
<div id="conteudo">
    <span class="lista_itens">
	<table class="ui-widget ui-widget-content matrix">
            <thead>
               <tr class="ui-widget-header">
                    <th>Nome do Posto</th>
                    <th>CNPJ</th>
                    <th>Endereço</th>
                    <th>Bandeira</th>
                    <th>Loja</th>
                    <th width="9%">Açoes</th>
                </tr>
            </thead>
            <tbody>
                <tr id="semresultado">
                    <td colspan="6">Sem Resultado</td>
                </tr>
                <?php
                foreach($Concorrentes as $campos=>$valores){
                ?>
                <tr>
                    <td><?php echo $valores['Codigo']." - ".$valores['NomePosto']; ?></td>
                    <td><?php echo  $objPosto->FormataCGCxCPF($valores['CNPJ']); ?></td>
                    <td><?php echo $valores['Endereco']; ?></td>
                    <td><?php echo $valores['Bandeira']; ?></td>
                    <td><?php echo $valores['Loja']; ?></td>
                    <td class="acoes">
                        <span class="lista_acoes">
                            <ul>
                                <li class="ui-state-default ui-corner-all" title="Alterar"  ><a href="?router=T0027/altera&cod=<?php echo $valores['Codigo'];?>"                                                     class="ui-icon ui-icon-pencil"               id=""          ></a></li>
<!--                                <li class="ui-state-default ui-corner-all" title="Excluir"  ><a href="javascript:excluir('T0025','T0025/home','T026_fornecedor','T026_codigo',<?php// echo ($valores['Codigo']);?>)"   class="ui-icon ui-icon-closethick"></a></li>-->
                            </ul>
                        </span>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
	</table>
    </span>
</div>
